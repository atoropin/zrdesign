
document.addEventListener('DOMContentLoaded',()=>{
    const brandsBlock = document.querySelector('.list-brands');
    const allBrands = document.querySelectorAll('.list-brands__item');
    const brandsImage = document.querySelectorAll('.menu-img');
    const ulBrands = document.querySelector('.list-brands');
    const brandsPath = [
        '/img/brands/audi.png',
        '/img/brands/bmw.png',
        '/img/brands/bmw_m.png',
        '/img/brands/mercedes.png',
        '/img/brands/mercedes_amg.png',
        '/img/brands/porsche.png',
        '/img/brands/landrover.png',
        '/img/brands/volkswagen.png'
    ];

    function changeImage (e){
        let target = e.target;
        let fileName = target.getAttribute('data-mark');
        if(target.classList.contains("menu-img") == true){
            allBrands.forEach(brand=>{
                if(brand.classList.contains('active-brand') == true){
                    brand.classList.remove('active-brand');
                }
            });
            brandsImage.forEach((img,idx)=>{
                img.setAttribute('src',brandsPath[idx]);
                if(brandsPath.length === idx+1){
                    switch(fileName){
                        case 'audi.png':
                            target.src = '/img/brands/hover/audi.png'
                            break;
                        case 'bmw.png':
                            target.src = '/img/brands/hover/bmw.png'
                            break;
                        case 'bmw_m.png':
                            target.src = '/img/brands/hover/bmw_m.png';
                            break;
                        case 'mercedes.png':
                            target.src = '/img/brands/hover/mercedes.png'
                            break;
                        case 'mercedes_amg.png':
                            target.src = '/img/brands/hover/mercedes_amg.png'
                            break;
                        case 'porsche.png':
                            target.src ='/img/brands/hover/porsche.png'
                            break;
                        case 'landrover.png':
                            target.src = '/img/brands/hover/landrover.png'
                            break;
                        case 'volkswagen.png':
                            target.src = '/img/brands/hover/volkswagen.png'
                            break;
                        default : {
                            // console.log(fileName);
                        }
                    };
                };

            });
            console.log()
            if( target.parentNode.parentNode.tagName != 'UL'){
                target.parentNode.parentNode.classList.add('active-brand');
                console.log(target.parentNode.parentNode.tagName)
            }else{
                target.parentNode.classList.add('active-brand');
            }
        }
    }

    brandsImage.forEach(img=>{
        let dataAttr = img.getAttribute('data-mark');
        if(dataAttr === 'audi.png' || dataAttr === 'bmw_m.png' || dataAttr === 'mercedes_amg.png' || dataAttr === 'landrover.png' ){
            img.classList.add('long');
        } else if(dataAttr === 'bmw.png' || dataAttr === 'audi.png' || dataAttr === 'volkswagen.png'){
            img.classList.add('small');
        }
    });

    brandsBlock.addEventListener('click',(e)=>{
        changeImage(e);
    });

    brandsBlock.addEventListener('mouseover',e=>{
        changeImage(e);
    });

});