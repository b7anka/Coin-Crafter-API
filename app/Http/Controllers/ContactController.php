<?php

namespace App\Http\Controllers;

use App\Mail\ContactedUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function showContactUs($lang)
    {
        $languagesAvailable = SharedMethodsController::languagesAvailable();

        if(!in_array($lang, $languagesAvailable))
        {
            $lang = 'en';
            App::setLocale($lang);
        }
        else
        {
            App::setLocale($lang);
        }
        return view('contactus');
    }

    public function sendMessage(Request $request)
    {
        $name = $request->name;
        $email = $request->email;
        $message = $request->message;
        $lang = $request->lang;
        App::setLocale($lang);

        if(empty($name) || empty($email) || empty($message))
        {
            $type = 'danger';
            $msg = __('strings.empty_user_inputs');

            $data = [
                'type'=>$type,
                'name'=>$name,
                'email'=>$email,
                '$message'=>$message,
                'msg'=>$msg
            ];

            return redirect('/support/'.$lang)->with('data',$data);
        }
        else
        {
            if(filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $data = [
                    'email'=>$email,
                    'name'=>$name,
                    'message'=>$message
                ];

                Mail::to('admin@b7anka.com')->send(new ContactedUsMail($data));

                $type = 'success';
                $msg = __('strings.contacted_us_successfully');

                $data = [
                    'type'=>$type,
                    'msg'=>$msg
                ];

                return redirect('/'.$lang)->with('data',$data);
            }
            else
            {
                $type = 'danger';
                $msg = __('strings.email_not_valid');

                $data = [
                    'type'=>$type,
                    'name'=>$name,
                    'email'=>$email,
                    '$message'=>$message,
                    'msg'=>$msg
                ];

                return redirect('/support/'.$lang)->with('data',$data);
            }
        }
    }
}
