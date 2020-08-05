$("#addimage").click(function(){
    //je recupere le num des future champs
    const index = +$('#widget-counter').val();


    //je recupere le prototype des entrees
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index );


    //j'inject ce code dans la div
    $('#ad_images').append(tmpl);

    $('#widget-counter').val(index + 1);

    //je gere le btn suppr
    handleDelteButton();
})


function handleDelteButton(){
    $('button[data-action = "delete"]').click(function(){
        const target = this.dataset.target;
        console.log(target);
        $(target).remove();
    })
}

function updateCounter(){
const count = +$('#ad_images div.form-group').length;
$('#widget-counter').val(count);
}


updateCounter();
handleDelteButton();