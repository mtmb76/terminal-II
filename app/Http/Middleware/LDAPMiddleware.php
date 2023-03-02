<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LDAPMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $ldap_server = env('LDAP_URL'); #'localfrio.com.br';
        $ldap_porta  = env('LDAP_PORT'); #'389';
        $user        = $request->email;
        $ldap_pass   = $request->password;

        try {
            $ldapcon     = ldap_connect($ldap_server, $ldap_porta);

            if ($ldapcon) {
                $bind   = ldap_bind($ldapcon, $user, $ldap_pass);
                $return = $bind;
            } else {
                $return = false;
            }
        } catch (\Throwable $th) {
            $return = false; 
        }

        if(!$return){
            return back()->withErrors([
                'email' => 'Não é possível validar suas credencias neste momento. Tente novamente em alguns minutos.',
            ])->onlyInput('email'); 
        }else{
            return $next($request);
        }
    }
}
