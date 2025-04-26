const btnSort = document.querySelectorAll("[btn-sort]")
if (btnSort.length > 0){
    btnSort.forEach(btn => {
        btn.addEventListener("click", () => {
            console.log(btn)
        })
    });
}