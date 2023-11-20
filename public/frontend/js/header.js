const listNavItem = document.querySelector('#list-nav-item')
const closeNav = document.querySelector('#closeNav')
document.querySelector('#openNav').addEventListener('click', (e) => {
    closeNav.classList.remove('d-none')
    listNavItem.classList.remove('d-none-response')
    listNavItem.classList.add('nav-burger')
})
document.querySelector('#closeNav').addEventListener('click', (e) => {
    listNavItem.classList.remove('nav-burger')
    listNavItem.classList.add('d-none-response')
    closeNav.classList.add('d-none')
})