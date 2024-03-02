$s1_src = env("TAWKTO_SCRIPT_URL");

if (!empty($s1_src)) {
    var Tawk_API = Tawk_API || {};
    Tawk_API.visitor = {
        name: "{{ auth()->user()->name }}",
    };
    (function () {
        var s1 = document.createElement("script"),
            s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = "{{ $s1_src }}";
        s1.charset = "UTF-8";
        s1.setAttribute("crossorigin", "*");
        s0.parentNode.insertBefore(s1, s0);
    })();
}
