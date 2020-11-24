$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    //ORDENAR MENU
    var almacenarOrdenId = [];
    var ordenItem = [];

    $(".ordenarSub").click(function(){

        var idMenu = $(this).attr("data-menu");
        var idSub = $(this).attr("data-subMenu");

        $(this).hide();
        $("#guardarOrdenSub"+idMenu).show();
        $(".flecha"+idMenu).show();

        $(".bloqueSub"+idMenu).css({"cursor":"move"});

        $("#itemSubMenu"+idMenu).sortable({
            revert: true,
            disabled: false,
            connectWith: ".bloqueSub"+idMenu,
            handle: ".handleSub"+idMenu,
            stop: function(event){

                for (var i = 0; i < $("#itemSubMenu"+idMenu+" li").length; i++) {

                    almacenarOrdenId[i] = event.target.children[i].id.slice(3);
                    ordenItem[i] = i+1;

                };
            }
        });

    });

    $(".guardarOrdenSub").click(function(){

        var idMenu = $(this).attr("data-menu");

        for (var i = 0; i < $("#itemSubMenu"+idMenu+" li").length; i++) {

            var actualizarOrden = new FormData();
            actualizarOrden.append("actualizarOrdenIdSub",almacenarOrdenId[i]);
            actualizarOrden.append("actualizarOrdenItemSub",ordenItem[i]);

            $.ajax({
                url:"views/ajax/menu",
                method: "POST",
                data: actualizarOrden,
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta){


                    $("#ordenarSub"+idMenu).show();
                    $("#guardarOrdenSub"+idMenu).hide();

                    $(".bloqueSub"+idMenu).css({"cursor":"default"});

                    $(".flecha"+idMenu).hide();
                    $("#itemSubMenu"+idMenu).sortable({disabled:true});

                }
            });

        };

    });


});
