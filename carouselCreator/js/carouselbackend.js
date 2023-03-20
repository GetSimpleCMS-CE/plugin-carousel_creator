var el = document.getElementById('sliderlister');
var sortable = Sortable.create(el, {
    animation: 200,
    group: 'slidelist',
    handle: '.drag'
});

//listfile

document
    .querySelectorAll('.listfile')
    .forEach(x => {
        x.style.display = "none";
    })

//drag

document
    .querySelectorAll('.drag')
    .forEach(x => {
        x.addEventListener('click', e => {
            e.preventDefault();
        })
    })

//editcontentshow hidden
document
    .querySelectorAll('.editcontentshow')
    .forEach(x => {
        x.style.display = "none";
    })

document
    .querySelectorAll('.carousel-items')
    .forEach((c, i) => {

        c
            .querySelector('.editcontent')
            .addEventListener('click', e => {
                e.preventDefault();

                if (c.querySelector('.editcontentshow').style.display == "none") {
                    c
                        .querySelector('.editcontentshow')
                        .style
                        .display = "block";
                } else {
                    c
                        .querySelector('.editcontentshow')
                        .style
                        .display = "none";
                }

            });

        c
            .querySelector('.takephoto')
            .addEventListener('click', x => {

                x.preventDefault();

                if (c.querySelector('.listfile').style.display === "none") {
                    c
                        .querySelector('.listfile')
                        .style
                        .display = "grid"
                } else if (c.querySelector('.listfile').style.display === "grid") {
                    c
                        .querySelector('.listfile')
                        .style
                        .display = "none";
                }

            })

        c
            .querySelectorAll('.thisphoto')
            .forEach(x => {

                x.addEventListener('click', b => {

                    b.preventDefault();

                    const link = x.getAttribute('href');

                    c
                        .querySelector('.image-car')
                        .value = link;

                    c
                        .querySelector('.listfile')
                        .style
                        .display = "none";

                })

            })

    })




    document.querySelector('.helpcontent').style.display="none";
    document.querySelector('.config').style.display="none";
   


    const options = document.querySelector('.options');

    options.querySelector('.help').addEventListener('click',(z)=>{

        z.preventDefault();

        document.querySelector('.config').style.display="none";
        document.querySelector('.uploader').style.display="none";

        document.querySelector('.helpcontent').style.display="block";
        document.querySelector('#sliderlist').style.display="none";

      });


      options.querySelector('.settings').addEventListener('click',(z)=>{

z.preventDefault();

document.querySelector('.config').style.display="block";
document.querySelector('.uploader').style.display="none";

document.querySelector('.helpcontent').style.display="none";
document.querySelector('#sliderlist').style.display="none";

});


options.querySelector('.sliderbtn').addEventListener('click',(z)=>{

z.preventDefault();

document.querySelector('.config').style.display="none";
document.querySelector('.uploader').style.display="block";

document.querySelector('.helpcontent').style.display="none";
document.querySelector('#sliderlist').style.display="block";

});


document.querySelector('form').setAttribute('enctype','multipart/form-data');









