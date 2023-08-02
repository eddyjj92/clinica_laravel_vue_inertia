export function toggleNavbar() {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
            document.body.classList.toggle('sb-sidenav-toggled');
        }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }
}

export function roundNumber(num, dec, simbolo = "") {
    if(dec===undefined) {
        dec=2;  // 2 decimales por defecto
    }
    return Number(num).toLocaleString('es-MX', {style: 'currency',currency: 'USD',minimumFractionDigits: dec, maximumFractionDigits: dec}).replace("USD", simbolo);
}

export function ripple(){
    document.querySelectorAll('.ripple').forEach(ripple => {
        ripple.addEventListener('mousedown', e => {
                let posX = e.pageX - ripple.getBoundingClientRect().left;
                let posY = e.pageY - ripple.getBoundingClientRect().top;
                let buttonWidth = 1.2 * ripple.offsetWidth;
                let divRippleEffect = document.createElement('div');
                divRippleEffect.className = 'ripple-effect';
                divRippleEffect.style.width = `${buttonWidth}px`;
                divRippleEffect.style.height = `${buttonWidth}px`;
                divRippleEffect.style.left = `${ posX - (buttonWidth / 2) }px`;
                divRippleEffect.style.top = `${ posY - (buttonWidth / 2) }px`;
                ripple.appendChild(divRippleEffect);

                window.setTimeout(() => {
                    ripple.removeChild(divRippleEffect);
                }, 1000);
        });
    });         
}





