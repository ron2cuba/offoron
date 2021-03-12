function cross(){
    const burger = document.querySelector('.burger');
    burger.classList.toggle('toggle');
    const line1 = document.querySelector('.line1');
    const line2 = document.querySelector('.line2');
    const line3 = document.querySelector('.line3');

    if(burger.classList.contains('toggle')){
        line2.style.opacity = `0`;
    } else {
        line2.style.opacity = `1`;
    }
}

const navSlide = () => {
    const burger = document.querySelector('.burger');
    const nav = document.querySelector('.nav-links');
    const navLinks = document.querySelectorAll('.nav-links li');
    // toggle nav
    burger.addEventListener('click', ()=>{
        if(!nav.classList.contains('nav-active')){
            nav.classList.toggle('nav-active');
            nav.setAttribute('style', 'transform: translateX(0%);');
        } else {
            nav.toggleAttribute('style');
            nav.classList.toggle('nav-active');
        }
        // animate links
        navLinks.forEach((link, index)=>{
            if(link.style.animation){
                link.style.animation = ''
            }else {
                link.style.animation = `fadeNavLinks 0.5s ease forwards ${index / 7 + .3}s`;
            }
        });
        //change burger
        cross();
    })
}
navSlide();