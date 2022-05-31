export default class getAjaxData {
    constructor() {
        this.btn = document.querySelector('.ajax-btn')
        //this.btnUrl = this.btn.getAttribute('href')
        this.testUrl = '/aliments'
        //this.bindEvents()
        this.loadUrl(this.testUrl);
    }

    bindEvents (){
        this.btn.addEventListener('click', e =>{
            e.preventDefault();
            this.loadUrl(testUrl);
        })
    }

    async loadUrl(url){

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        if(response.status >= 200 && response.status < 300){
            const data = await response.json();
            console.log(data.content);
        } else{
            console.error(response)
        }
    }
}