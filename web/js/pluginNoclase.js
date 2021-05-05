jQuery(function ($) {
    $(document).ready(function() {
        $('#titulo').typeIt({
            strings: ["Recursos educativos accesibles,", "facilitadores y gratuitos."],
            speed: 50
        });

        $('#dAzul').fadeIn("slow");
    });
});
