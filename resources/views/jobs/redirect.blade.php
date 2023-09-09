<!DOCTYPE html>
<html lang="en">
<head>
      <title>Ajiriwa: redirecting</title>
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <meta name="robots" content="noindex">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
      <link rel="stylesheet" href="{{ mix('css/app.css') }}">
      
     <!-- <link href="http://s2.newsnow.net/scache/11_0_e0770ef960813ff4b0bdaa46acc856de.css" rel="stylesheet" type="text/css" />-->
	 <style>
	 @keyframes slide{0%{transform:translate3d(0%,0,0)}
50%{transform:translate3d(100%,0,0)}
0%{transform:translate3d(0%,0,0)}
}
html,body{height:100%}
body{/* font-family:Arial,Helvetica,sans-serif; */margin:0px;padding:0px;background-image:url('/ico/retrieval_bg.jpg');background-repeat:repeat;background-position:center;background-size:200px;color:#333333;font-size:16px;line-height:1.4;position:relative}
a{border:none;color:#6699CC}
a:visited,a:focus,a:active,a:hover{border-color:#6699CC;color:#6699CC;text-decoration:none}
p{margin:.5em 0}
.c-center-parent{display:table;width:100%;height:100%}
.c-center-child{display:table-cell;text-align:center;vertical-align:middle}
.retrieval-header{max-width:473px;margin-left:auto;margin-right:auto;width:70%}
.retrieval-branding{margin-top:1em;margin-bottom:1em}
.retrieval-branding img{width:100%;max-width:100%;height:auto}
.retrieval-loader{margin:3em auto 4em auto}
.error .retrieval-loader{display:none}
.retrieval-loader .loader{width:100%;height:7px;background-color:#e6e9ed;position:relative;overflow:hidden}
.retrieval-loader .loader-anim-container{width:86.9565%;height:100%;animation-name:slide;animation-duration:3s;animation-fill-mode:both;animation-iteration-count:infinite}
.retrieval-loader .loader-progress{height:100%;width:15%;background-color:rgb(22 163 74);display:inline-block;position:absolute;left:0}
.ltie10 .retrieval-loader{display:none}
.retrieval-msg{opacity:0;font-size:.938em;margin:1em 0;padding:0 1.25em;transition:opacity .5s ease-in}
.retrieval-msg.is-visible{opacity:1}
.error .retrieval-msg{max-height:initial;opacity:1}
@media(min-width:568px){.retrieval-msg{font-size:1.250em;padding:0 1em}
}
.retrieval-highlight{color:#6699CC}
.retrieval-disclaimer{background-color:white;box-sizing:border-box;color:#999999;font-size:13px;position:fixed;bottom:0;width:100%;padding:.75em;text-align:center}
.error .retrieval-disclaimer{display:none}
.retrieval-error-msg{width:70%;margin-left:auto;margin-right:auto}
	 </style>
<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"DJY7r1rqDC20HD", domain:"ajiriwa.net",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://certify-js.alexametrics.com/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://certify.alexametrics.com/atrk.gif?account=DJY7r1rqDC20HD" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->  	  

   </head>
  <body class="">
      <div class="c-center-parent">
         <div class="c-center-child">
            <div class="retrieval-header">
               <div class="retrieval-branding flex">
                    <section class="flex-grow"></section>
                    <section class="flex space-x-2">
                        <img style="width: 50px" src="https://beta.ajiriwa.net/images/ajiriwa-new-logo.png">
                        <span class="text-gray-500 font-bold self-center text-2xl">Ajiriwa.net</span>
                    </section>
                    <section class="flex-grow"></section>
               </div>
               <div class="retrieval-loader">
                  <div class="loader">
                     <div class="loader-anim-container">
                        <span class="loader-progress"></span>
                     </div>
                  </div>
               </div>
            </div>
            <div >
                <p>{{ ''/* $link */ }}</p>
                <p class="text-gray-500">You are now going out of Ajiriwa Network</p>
                  <p>
      <strong  style="color: #26ae61">Page not loading?</strong>
      Try clicking <strong><a rel="nofollow" href="{{ request()->link }}">here</a></strong>.
   </p>
            </div>

         </div>
      </div>
      <div class="retrieval-disclaimer">
         <p></p>
      </div>
	  <div id="redir"></div>
         <form name="form-url" method="get" action="/A/3/909533465"></form>
		 <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
var redir = "{{ request()->link }}";

$(document).ready(function(){
    //alert(redir)
	window.location.href=redir;
})
</script>
   </body>
</html>
