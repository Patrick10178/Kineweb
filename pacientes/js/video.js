let btn = document.querySelector('.btn');
let clip = document.querySelector('.clip');
let close = document.querySelector('.close');
btn.onclick = function(){
    btn.classList.add('active');
    clip.classList.add('active');
}
close.onclick = function(){
    btn.classList.remove('active');
    clip.classList.remove('active');
    setTimeout(function(){
        location.reload();
    },1000);
}

