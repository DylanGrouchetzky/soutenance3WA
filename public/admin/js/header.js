const listNavItem = document.querySelector('#list-nav-item')
const closeNav = document.querySelector('#closeNav')
const containerNav = document.querySelector('#container-nav')
const btnOpenNav = document.querySelector('#openNav')
document.querySelector('#openNav').addEventListener('click', (e) => {
    listNavItem.classList.remove('d-responsive-none')
    listNavItem.classList.add('nav-burger')
    closeNav.classList.remove('d-none')
})
document.querySelector('#closeNav').addEventListener('click', (e) => {
    listNavItem.classList.add('d-responsive-none')
    listNavItem.classList.remove('nav-burger')
    closeNav.classList.add('d-none')
})