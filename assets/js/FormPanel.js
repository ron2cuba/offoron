// si la route est /admin
if(window.location.href.search('/admin')){
    // //stockage loader
    // let gifLoader;
    // if(document.querySelector('.container.admin')){
    //     gifLoader = document.querySelector('.container.admin').getAttribute('data-loader');
    // }
    /**
     * Chargement de la page admin dans le template id="home"
     */
    function homeAdmin(){
        window.addEventListener('DOMContentLoaded', (e)=>{
            document.querySelector('.rendering').innerHTML = '';
            let template = document.getElementById('home');
            let content = template.content;
            document.querySelector('.rendering').appendChild(content);
        });
    }

    /**
     * Creation du template sur la page admin pour l'edition ou la creation d'un element
     */
    function dataToManage(){

        const clickPossibilities = {
            creates : document.querySelectorAll('.create'),
            edits : document.querySelectorAll('.edit'),
            admin : document.querySelector('.back-to-admin'),
        }
        const myClass = {
            create: 'create',
            edit: 'edit',
        }
        const entities = {
            style: "style",
            band: "band",
            album: "album",
            memeber: "member",
        }

        // browse selected class
        for (let i = 0; i < clickPossibilities.creates.length; i++) {

            // create is clicked
            if(clickPossibilities.creates[i].className.includes(myClass.create)){
                clickPossibilities.creates[i].addEventListener('click', (e)=>{

                    e.preventDefault();
                    console.log('click create');

                    document.querySelector('.rendering').innerHTML = '';

                    
                    // stop event listener
                    if (e.stopPropagation){
                        e.stopPropagation();
                    }

                    /**
                     * action
                     */
                     initTemplateBand();
                    // style clicked
                    if(e.target.className.includes("style")){

                    };
                    
                })
            }
            // edit is clicked
            if(clickPossibilities.edits[i].className.includes(myClass.edit)){
                clickPossibilities.edits[i].addEventListener('click', (e)=>{
                    e.preventDefault();
                    console.log('edit');

                    /**
                     * action
                     */
                    
                    if (e.stopPropagation){
                        e.stopPropagation();
                    } 
                });
            }
            
            
        }
    }

    function backToAdmin(){

        let back = document.querySelector('.back-to-admin');
        back.addEventListener('click', (e)=>{
            e.preventDefault();
            
            let template = document.getElementById('home');
            let content = template.content;
            document.querySelector('.rendering').appendChild(content);
            console.log('back to home');
        });
    }

    function initTemplateStyle(){

        document.querySelector('.rendering').innerHTML = '';

        let template = document.getElementById('create-band');
        let content = template.content;
        // console.log(content);
        document.querySelector('.rendering').appendChild(content);
    }
    function initTemplateBand(){


        let template = document.getElementById('create-band');
        let content = template.content;
        // console.log(content);
        document.querySelector('.rendering').appendChild(content);
    }

    function razTemplate(){
        document.querySelector().innerHTML = "";
    }


    homeAdmin();
    backToAdmin();
    dataToManage();
}