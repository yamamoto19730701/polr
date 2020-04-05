<h3>{{__("Hello username",['username'=>$username])}}</h3>

<p>{{__("Thanks for registering at appname. To use your account, you will need to activate it by clicking the following link",['appname'=>env('APP_NAME')])}}</p>

<br />

<a href='{{env('APP_PROTOCOL')}}{{env('APP_ADDRESS')}}/activate/{{$username}}/{{$recovery_key}}'>
    {{env('APP_PROTOCOL')}}{{env('APP_ADDRESS')}}/activate/{{$username}}/{{$recovery_key}}
</a>

<br />

<p>{{__("Thanks,")}}</p>
<p>{{__("The appname team.",['appname'=>env('APP_NAME')])}}</p>

--
<br />
{{__("You received this email because someone with the IP ip signed up for an account at APP_PROTOCOL APP_ADDRESS. If this was not you,you may ignore this email.",['ip'=>$ip,'appprotocol'=>env('APP_PROTOCOL'),'appaddress'=>env('APP_ADDRESS')])}}

