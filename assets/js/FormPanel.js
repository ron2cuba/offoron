// si la route est /admin
if(window.location.href.search('/admin')){

    /**
     * elts to click => Create
     */
    let createBand = document.querySelector('.create-band');
    let editBand = document.querySelector('.edit-band');
    let createStyle = document.querySelector('.create-style');
    let editStyle = document.querySelector('.edit-style');
    let createAlbum = document.querySelector('.create-album');
    let editAlbum = document.querySelector('.edit-album')
    let createMember = document.querySelector('.create-member');
    let editMember = document.querySelector('.edit-member');
    /**
     * elts to click => Modifications
     */
    let mainDisplay = document.querySelector('.main-display');
    let backToADmin = document.querySelector('.back-to-admin');


    /**
     * creation de l'iframe qui appel le template twig pour creation ou edition
     * @param {Element} element lien qui sera écouté au click
     * @param {string} thingsToWork string entité ou identifiant de groupe
     * @param {string} action string action possible
     */
    function dataToCreate(element, thingsToWork, action){

        let regex = new RegExp('^create$');

        if(regex.test(action) && element){

            element.addEventListener('click', (e)=>{
                e.preventDefault();
                console.log('click');
                const gifLoader = document.querySelector('.container.admin').getAttribute('data-loader');
                let html = `<iframe class="admin" src="/admin/${thingsToWork}/${action}" style="background:url('${gifLoader}') center / 4rem no-repeat #fff;" scrolling="no"></iframe>`;

                mainDisplay.innerHTML = html;

            });

        }
            
    }
        
    /**
     * 
     * @param {Element} element lien qui porte le eventlistener
     */
    function dataToManage(element, page){

        const regex = new RegExp('^edit$');
        
        if(regex && element){
            element.addEventListener('click',()=>{
                console.log('click');
                const gifLoader = document.querySelector('.container.admin').getAttribute('data-loader');
                let html = `<iframe class="admin" src="/admin/${page}-list" style="background:url('${gifLoader}') center / 4rem no-repeat #fff;" scrolling="no"></iframe>`;
                document.querySelector('.main-display').innerHTML = html;
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

    // quand je click place dans l'iframe une page qui liste tous les groupes


    backToAdminPage();
    /**
     * Create
     */
    dataToCreate(createStyle, 'style', 'create');
    dataToCreate(createBand, 'band', 'create');
    dataToCreate(createAlbum, 'album', 'create');
    dataToCreate(createMember, 'member', 'create');
    /**
     * Modifications
     */
    dataToManage(editStyle, 'edit/styles');
    dataToManage(editBand, 'edit/bands');
    dataToManage(editAlbum, 'edit/albums');
    dataToManage(editMember, 'edit/members' );

    
}