<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CIAuth;
use App\Libraries\Hash;
use App\Models\User;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class AuthController extends BaseController
{
    protected $helpers = ['url', 'form', 'CIMail', 'CIFunctions'];
    public function loginForm()
    {
        $data = [
            'tabTitle' => 'Login',
            'validation' => null,
        ];
        return view('backend/pages/auth/login', $data);
    }

    public function loginHandler()
    {
        $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|valid_email|is_not_unique[users.email]',
                    'errors' => [
                        'required' => 'Email is required!',
                        'valid_email' => 'Please enter a valid email format!',
                        'is_not_unique' => 'Email not available',
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[25]',
                    'errors' => [
                        'required' => 'Password is required!',
                        'min_length' => 'The password must be at least 5 characters long',
                        'max_length' => 'The password must have a maximum length of 25 characters',
                    ]
                ]
            ]);
        } else {
            $isValid = $this->validate([
                'login_id' => [
                    'rules' => 'required|is_not_unique[users.username]',
                    'errors' => [
                        'required' => 'Username is required!',
                        'is_not_unique' => 'Username not available',
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[5]|max_length[25]',
                    'errors' => [
                        'required' => 'Password is required!',
                        'min_length' => 'The password must be at least 5 characters long',
                        'max_length' => 'The password must have a maximum length of 25 characters',
                    ]
                ]
            ]);
        }

        if (!$isValid) {
            return view('backend/pages/auth/login', [
                'tabTitle' => 'Login',
                'validation' => $this->validator
            ]);
        } else {
            $user = new User();
            $userInfo = $user->where($fieldType, $this->request->getVar('login_id'))->first();
            $check_password = Hash::check($this->request->getVar('password'), $userInfo['password']);

            if (!$check_password) {
                return redirect()->route('admin.login.form')->with('fail', 'Wrong Password')->withInput();
            } else {
                CIAuth::setCIAuth($userInfo); //! Line Penting
                return redirect()->route('admin.home');
            }
        }
    }

    // public function loginAPI()
    // {
    //     $fieldType = filter_var($this->request->getVar('login_id'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    //     if ($fieldType == 'email') {
    //         $isValid = $this->validate([
    //             'login_id' => [
    //                 'rules' => 'required|valid_email|is_not_unique[users.email]',
    //                 'errors' => [
    //                     'required' => 'Email is required!',
    //                     'valid_email' => 'Please enter a valid email format!',
    //                     'is_not_unique' => 'Email not available',
    //                 ]
    //             ],
    //             'password' => [
    //                 'rules' => 'required|min_length[5]|max_length[25]',
    //                 'errors' => [
    //                     'required' => 'Password is required!',
    //                     'min_length' => 'The password must be at least 5 characters long',
    //                     'max_length' => 'The password must have a maximum length of 25 characters',
    //                 ]
    //             ]
    //         ]);
    //     } else {
    //         $isValid = $this->validate([
    //             'login_id' => [
    //                 'rules' => 'required|is_not_unique[users.username]',
    //                 'errors' => [
    //                     'required' => 'Username is required!',
    //                     'is_not_unique' => 'Username not available',
    //                 ]
    //             ],
    //             'password' => [
    //                 'rules' => 'required|min_length[5]|max_length[25]',
    //                 'errors' => [
    //                     'required' => 'Password is required!',
    //                     'min_length' => 'The password must be at least 5 characters long',
    //                     'max_length' => 'The password must have a maximum length of 25 characters',
    //                 ]
    //             ]
    //         ]);
    //     }

    //     if (!$isValid) {
    //         $response = [
    //             'status' => 0,
    //             'message' => 'Validation failed',
    //             'errors' => $this->validator->getErrors(),
    //         ];

    //         return json_encode($response);
    //     } else {
    //         $user = new User();
    //         $userInfo = $user->where($fieldType, $this->request->getVar('login_id'))->first();
    //         $check_password = Hash::check($this->request->getVar('password'), $userInfo['password']);

    //         if (!$check_password) {
    //             $response = [
    //                 'status' => 0,
    //                 'message' => 'Wrong Password',
    //             ];

    //             return json_encode($response);
    //         } else {
    //             CIAuth::setCIAuth($userInfo);

    //             $response = [
    //                 'status' => 1,
    //                 'user' => [
    //                     'id' => $userInfo['id'],
    //                     'username' => $userInfo['username'],
    //                     'email' => $userInfo['email'],
    //                     'password' => $userInfo['password'],
    //                     'picture' => $userInfo['picture'],
    //                     'bio' => $userInfo['bio'],
    //                 ],
    //             ];

    //             return json_encode($response);
    //         }
    //     }
    // }

    public function forgotForm()
    {
        $data = array(
            'tabTitle' => 'Forgot Password',
            'validation' => null,
        );

        return view('backend/pages/auth/forgot', $data);
    }

    public function sendPasswordResetLink()
    {
        $isValid = $this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required!',
                    'valid_email' => 'Please enter a valid email format!',
                    'is_not_unique' => 'Email not available',
                ],
            ]
        ]);

        if (!$isValid) {
            return view('backend/pages/auth/forgot', [
                'tabTitle' => 'Forgot Password',
                'validation' => $this->validator,
            ]);
        } else {
            //! Get user (admin) detail
            $user = new User();
            $user_info = $user->asObject()->where('email', $this->request->getVar('email'))->first();

            //! Generate Token
            $token = bin2hex(openssl_random_pseudo_bytes(65));

            //! Get Reset Password Token
            $password_reset_token = new PasswordResetToken();
            $isOldTokenExists = $password_reset_token->asObject()->where('email', $user_info->email)->first();

            if ($isOldTokenExists) {
                $password_reset_token->where('email', $user_info->email)->set([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ])->update();
            } else {
                $password_reset_token->insert([
                    'email' => $user_info->email,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
            }

            //! Create action link
            $actionLink = base_url(route_to('admin.reset-password', $token));
            // $actionLink = route_to('admin.reset-password', $token);

            $mail_data = array(
                'actionLink' => $actionLink,
                'user' => $user_info,
            );

            $view = \Config\Services::renderer();
            $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/forgot-email-template');

            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $user_info->email,
                'mail_recipient_name' => $user_info->name,
                'mail_subject' => 'Reset Password',
                'mail_body' => $mail_body
            );

            //! Send Email
            if (sendEmail($mailConfig)) {
                return redirect()->route('admin.forgot.form')->with('success', 'We have sent a password reset link to your email.');
            } else {
            }
        }
    }

    public function resetPassword($token)
    {
        $passwordResetPassword = new PasswordResetToken();
        $check_token = $passwordResetPassword->asObject()->where('token', $token)->first();
        if (!$check_token) {
            return redirect()->route('admin.forgot.form')->with('fail', 'Invalid token. Request another reset password link.');
        } else {
            //! Cek jika token tidak expired (tidak lebih dari 15 menit);
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if ($diffMins > 15) {
                //! Jika token expired
                return redirect()->route('admin.forgot.form')->with('fail', 'Token expired. Request another reset password link.');
            } else {
                return view('backend/pages/auth/reset', [
                    'tabTitle' => 'Reset Password',
                    'validation' => null,
                    'token' => $token,
                ]);
            }
        }
    }

    public function resetPasswordHandler($token)
    {
        // echo $token;
        $isValid = $this->validate([
            'new_password' => [
                'rules' => 'required|min_length[5]|max_length[25]|is_password_strong[new_password]',
                'errors' => [
                    'required' => 'Enter new password',
                    'min_length' => 'New password must be at least 5 characters long',
                    'max_length' => 'New password must have a maximum length of 25 characters',
                    'is_password_strong' => 'New password must contains atleast 1 uppercase, 1 lowercases, 1 number and 1 special character.',
                ]
            ],
            'confirm_new_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Confirm new password',
                    'matches' => 'Passwords not matches.'
                ]
            ]
        ]);

        if (!$isValid) {
            return view('backend/pages/auth/reset', [
                'tabTitle' => 'Reset Password',
                'validation' => null,
                'token' => $token,
            ]);
        } else {
            //! Get Token Detail
            $passwordResetPassword = new PasswordResetToken();
            $get_token = $passwordResetPassword->asObject()->where('token', $token)->first();

            //! Get User (Admin) Detail
            $user = new User();
            $user_info = $user->asObject()->where('email', $get_token->email)->first();

            if (!$get_token) {
                return redirect()->back()->with('fail', 'Invalid Token!')->withInput();
            } else {
                //! Update Password Admin di Database
                $user->where('email', $user_info->email)->set([
                    'password' => Hash::make($this->request->getVar('new_password'))
                ])->update();

                //! Kirim Notifikasi ke Email User (Admin)
                $mail_data = array(
                    'user' => $user_info,
                    'new_password' => $this->request->getVar('new_password')
                );

                $view = \Config\Services::renderer();
                $mail_body = $view->setVar('mail_data', $mail_data)->render('email-templates/password-changed-email-template');

                $mailConfig = array(
                    'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                    'mail_from_name' => env('EMAIL_FROM_NAME'),
                    'mail_recipient_email' => $user_info->email,
                    'mail_recipient_name' => $user_info->name,
                    'mail_subject' => 'Reset Password',
                    'mail_body' => $mail_body
                );

                if (sendEmail($mailConfig)) {
                    //! Hapus Token
                    $passwordResetPassword->where('email', $user_info->email)->delete();

                    //! Kembali dan muncul pesan pada halaman Login
                    return redirect()->route('admin.login.form')->with('success', 'Done!, Your password has been changed. Use new password to login into system.');
                } else {
                    return redirect()->back()->with('fail', 'Something went wrong')->withInput();
                }
            }
        }
    }
}
