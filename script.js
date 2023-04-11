

function get_possibility(pieces) {
    fetch("fetch/get_possibility.php",{
        method : "POST",
        body : JSON.stringify({
            pieces : pieces
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
                console.log()
                document.querySelector('.tray .cells:nth-child('+(parseInt(lst_case[i])+1)+')').classList.add('active');
            }
        })
}

