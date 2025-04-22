<?php

namespace Cyaxaress\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Cyaxaress\User\Mail\VerifyCodeMail;
use Cyaxaress\User\Models\User;
use Cyaxaress\User\Rules\ValidMobile;
use Cyaxaress\User\Rules\ValidPassword;
use Cyaxaress\User\Services\VerifyCodeService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/email/verify'; // Redirect to verification page

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['nullable', 'string', 'min:9', 'max:14', 'unique:users', new ValidMobile()],
            'password' => ['required', 'string', 'confirmed', new ValidPassword()],
        ], [
            'email.unique' => 'This email is already registered.',
            'mobile.unique' => 'This mobile number is already registered.',
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

        // 🔐 Generate a verification code
        $code = VerifyCodeService::generate();

        // 🗃️ Store it in the cache
        VerifyCodeService::store($user->id, $code, now()->addMinutes(15));

        // 📧 Send email
        Mail::to($user->email)->send(new VerifyCodeMail($code));

        return $user;
    }

    public function showRegistrationForm()
    {
        return view('User::Front.register');
    }
}
