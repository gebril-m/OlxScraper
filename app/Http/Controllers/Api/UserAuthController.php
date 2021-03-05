<?php


namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiAuthHelper;
use App\Http\Controllers\Api\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;

class UserAuthController extends Controller
{

    use ApiResponseHelper, ApiAuthHelper;

    public $userRepo;


    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    function sendSMS(Request $request)
    {
        $phone = $request->phone;
        $data = ['code' => "1234"];
        return $this->setCode(200)->setData($data)->send();
    }

    function verifySMS(Request $request)
    {
        $phone = $request->phone;
        $code = $request->code;
        $user = $this->userRepo->findByPhone($phone);
        if($user) {
            $data['user_register'] = "yes";
        }
        else{
            $data['user_register'] = "no";
        }
        if ($code == 1234) {
            return $this->setCode(200)->setData($data)->setSuccess("Successfully Verified")->send();
        } else {
            return $this->setCode(401)->setSuccess("Error Verified Code")->send();
        }
    }


    function register(Request $request)
    {

        $rules = [
            'phone' => 'required|unique:users',
            'parent_code' => 'nullable|exists:users,affiliate_code'
        ];
        // Validate Data
        $validator = $this->validate($request->all(), $rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                if ($validator->errors()->has('phone'))
                    return $this->setCode(400)->setError($message)->send();
                elseif ($validator->errors()->has('parent_code'))
                    return $this->setCode(400)->setError($message)->send();
            }
        }

        $data = $request->except('password');
//        $bcryptPass = bcrypt($request->get('password'));
        //$data = array_add($data, 'password', $bcryptPass);
        $aff_code = str_replace(' ', '', $request['name']) . rand(5, 150) . rand(1, 100);
        $data = array_add($data, 'affiliate_code', $aff_code);

        if ($request['parent_code'] ?? null) {
            $parent = $this->userRepo->findByCode($request['parent_code']);
            $data = array_add($data, 'parent_id', $parent->id);
        }
        $user = $this->userRepo->save($data);
        $userRes = new UserResource($user);
        // do login
        //$input = $request->only('email', 'password');
        $token = $this->doLogin($user);
        if ($token) {
            $data = ['token' => $token, 'user' => $userRes];
            return $this->setCode(200)->setData($data)->send();
        }
        return $this->setCode(401)->setError('Error in register')->send();
    }


    function login(Request $request)
    { 

        $phone = $request->only('phone');
        $user = $this->userRepo->findByPhone($phone);
        //return $user;
        if(isset($user)){
        	if( auth()->attempt(['phone'=>$request->phone,'password'=>$request->password])){

        		$token = $this->doLogin($user);
	            $userData = $this->getAuthUser();
	            if ($token) {
	                $data = ['token' => $token, 'user' => new UserResource($user)];
	                return $this->setCode(200)->setData($data)->send();
	            }

        	}else{
        		return $this->setCode(401)->setError('Data incorrect, Please Write Correct data')->send();
        	}
	            
        }
        return $this->setCode(401)->setError('Phone Not Found , Please Register')->send();
    }


}

