$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    //ORDENAR MENU
    var almacenarOrdenId = [];
    var ordenItem = [];

    $("#ordenarMenu").click(function(){

        $("#ordenarMenu").hide();
        $("#guardarOrden").show();
        $(".flecha").show();

        $(".bloque").css({"cursor":"move"});

        $("#itemMenu").sortable({
            revert: true,
            disabled: false,
            connectWith: ".bloque",
            handle: ".handle",
            stop: function(event){

                for (var i = 0; i < $("#itemMenu li").length; i++) {

                    almacenarOrdenId[i] = event.target.children[i].id;
                    ordenItem[i] = i+1;



                };
            }
        });

    });

    $("#guardarOrden").click(function(){

        for (var i = 0; i < $("#itemMenu li").length; i++) {

            var actualizarOrden = new FormData();
            actualizarOrden.append("actualizarOrdenId",almacenarOrdenId[i]);
            actualizarOrden.append("actualizarOrdenItem",ordenItem[i]);

            $.ajax({
                url:"views/ajax/menu",
                method: "POST",
                data: actualizarOrden,
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta){


                    $("#ordenarMenu").show();
                    $("#guardarOrden").hide();

                    $(".bloque").css({"cursor":"default"});

                    $(".flecha").hide();
                    $("#itemMenu").sortable({disabled:true});

                }
            });

        };

    });


});
