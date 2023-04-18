

function get_possibility(pieces,i,j) {
    fetch("fetch/get_possibility.php",{
        method : "POST",
        body : JSON.stringify({
            pieces : pieces,
            i : i,
            j : j
        })

    })
        .then(result => result.text())
        .then(data => {
            console.log(data);
            const lst_case = data.split(',')
            for (let i = 1 ; i < 64 ; i++) {
                document.querySelector('.tray .cells:nth-child('+i+')').classList.remove('active');
            }
            for (let i = 0 ; i < lst_case.length -1 ; i++) {
                document.querySelector('.tray .cells:nth-child('+(parseInt(lst_case[i])+1)+')').classList.add('active');
            }
        })
}



function go_to(id) {
    if (document.getElementById(id).classList.contains('active')){
        fetch("fetch/new_map.php",{
            method : "POST",
            body : JSON.stringify( {
                cases : id
            })
        })
            .then(r => r.text())
            .then(r => {
                document.querySelector('.tray').remove();
                document.querySelector('body').innerHTML += r;
            })
    }
}

