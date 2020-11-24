$(document).ready(function () {

    var ganador = [2, 12, 19, 35, 44, 45];

    $(".numPrimitiva").focus(function () {

        $(".numPrimitiva").css("background-color", "white");

    });

    $(".numPrimitiva").blur(function () {

        var inputs = $(".numPrimitiva");

        for (var i = 0; i < inputs.length; i++) {

            if ($.inArray(parseInt($(inputs[i]).val()), ganador) !== -1) {
                $(inputs[i]).css("background-color", "green");
                console.log("verde");
            } else {
                $(inputs[i]).css("background-color", "red");
                console.log("rojo");
            }

        }

    });

});
