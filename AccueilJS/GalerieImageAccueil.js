function displayImg(link) {

    overlay = document.getElementById('overlay'),
    overlay.style.display = 'block';
    document.getElementById('imgOverlay').src = link.href;
    document.getElementById('titreimg').innerHTML=link.title;

}

function reverseDisplayImg()
{
    overlay = document.getElementById('overlay'),
    overlay.style.display = 'none';
}

$(document).ready(function(){
    $('#galerie1').on('click',function(e){receiveClick(e);});
    $('#galerie2').on('click',function(e){receiveClick(e);});
    $('#galerie3').on('click',function(e){receiveClick(e);});
    $('#galerie4').on('click',function(e){receiveClick(e);});
    $('#galerie5').on('click',function(e){receiveClick(e);});
    $('#galerie6').on('click',function(e){receiveClick(e);});
    $('#galerie7').on('click',function(e){receiveClick(e);});
    $('#galerie8').on('click',function(e){receiveClick(e);});
});

function receiveClick(e)
{
    e.preventDefault();
    displayImg(e.currentTarget);
}
