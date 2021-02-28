const template = document.createElement('template');
template.innerHTML = `
<style></style>
<div class="row">
  <img src="..." class="col img-fluid overlay" alt="...">
  <div part="details" class="col">
    <h5 class="mt-0">Columns with stretched link</h5>
    <p class="justify"><slot name="description"/>Description.</p>
    <a href="#" class="stretched-link">Détails</a>
  </div>
</div>
`;
class BandCard extends HTMLElement{
    constructor(){
        super();
        this.attachShadow({mode: 'open'})
        this.shadowRoot.appendChild(template.content.cloneNode(true));
        this.shadowRoot.querySelector('style').innerText = this.createStyle();
        this.shadowRoot.querySelector('h5').innerText = this.getAttribute('name');
        this.shadowRoot.querySelector('img').src = this.getAttribute('image');
        this.shadowRoot.querySelector('img').alt = 'image de' + this.getAttribute('name');
    }
    createStyle(){
        let css = 
        `.row{box-shadow:var(--box-shadow, 0 2px 5px 0 rgba(0,0,0,.25),0 3px 10px 0 rgba(0,0,0,.2));background:var(--background, rgb(255, 255, 255));display: grid;grid-template-columns:2fr 3fr;margin-top:1rem;border-top-left-radius: 2rem;border-bottom-left-radius:1rem;border-top-right-radius:1rem;border-bottom-right-radius:2rem;text-align: center;border:var(--border, 1px solid #EEEEEE);overflow-wrap: break-word;}
        img{border-top-left-radius: 2rem;border-bottom-left-radius:1rem;border-top-right-radius:.5rem;border-bottom-right-radius:.5rem;height:300px}
        .overlay{opacity:1;transition: all .3s ease-in-out;}
        .overlay:hover{opacity:0.6;cursor:pointer;}
        .justify{text-align: justify;overflow-wrap: break-word;}
        p{padding:.2rem;font-size:1rem;color:#424242}h5{color:#212121;font-size:2rem;}
        a{color:#fff;box-shadow: 0 2px 5px 0 rgb(0 0 0 / 20%), 0 2px 10px 0 rgb(0 0 0 / 10%);background-color:#1abe5c;font-weight: 500;padding: .625rem 1.5rem .5rem;font-size: .75rem;line-height: 1.5;}
        `
        return css;
    }
    
    connectedCallback(){
        this.shadowRoot.querySelector('img').addEventListener('click', ()=>{
            console.log('yeah!');
        });
    }

    disconnectedCallback() {
        console.log('Custom square element removed from page.');
    }
    
} // end class

customElements.define('offoron-band', BandCard);