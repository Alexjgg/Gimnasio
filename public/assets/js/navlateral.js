addEventListener('DOMContentLoaded',() =>{
    //Menu
    // menu lateral el cambio de el signo flecha y la clase que oculta y muestra el menu
    const btn_sidenav = document.querySelector('.btn_sidenav')
    if(btn_sidenav) {
        btn_sidenav.addEventListener('click',()=>{
            const menu_items = document.querySelector('#sidebar')
            menu_items.classList.toggle('active')
            btn_sidenav.innerHTML='&#8594;'
            if( menu_items.className=='active' ){
             btn_sidenav.innerHTML='<span class="arrow">&#8594;</span>'
            }else{
                
                btn_sidenav.innerHTML='<span class="arrow">&#8592;</span>';
            }        
        })
    }
})