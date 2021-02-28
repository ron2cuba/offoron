// si la route est /admin
if(window.location.href.search('/admin')){

    /**
     * Créations 
     */
    let createBand = document.querySelector('.create-band');
    let createStyle = document.querySelector('.create-style');
    let createAlbum = document.querySelector('.create-album');
    let createMember = document.querySelector('.create-member');
    /**
     * Modifications
     */
    
    
    let mainDisplay = document.querySelector('.main-display');
    let backToADmin = document.querySelector('.back-to-admin');

    /**
     * creation de l'iframe qui appel le template twig
     * @param {Element} element lien qui sera écouté au click
     * @param {string} entity string entity
     * @param {string} action string action possible
     */
    function create(element, entity, action){

        let regex = new RegExp('^create$' || '^edit$' || '^delete$');

        if(regex.test(action) && element){

            element.addEventListener('click', (e)=>{
                e.preventDefault();
                
                const gifLoader = document.querySelector('.container.admin').getAttribute('data-loader');
                const iframe = document.querySelector('iframe.admin');
                let html = `<iframe class="admin" src="/admin/${entity}/${action}" style="background:url('${gifLoader}') center / 4rem no-repeat #fff;" ></iframe>`;

                mainDisplay.innerHTML = html;

            });

            }
            
        }

    function backToAdminPage(){
        if(backToADmin){
            backToADmin.addEventListener('click', (e)=>{
                window.location = '/admin'
            });
        }
    }

    backToAdminPage();
    create(createStyle, 'style', 'create');
    create(createBand, 'band', 'create');
    create(createAlbum, 'album', 'create');
    create(createMember, 'member', 'create');

    
}