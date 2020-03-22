(function() {
    
    let input = document.getElementById('search-input')
    let div = document.getElementById('names')
    let dupes = document.getElementById('dupes')
    let allowDupes = document.getElementById('allow-dupes')

    allowDupes.style.color = allowDupes.checked === true ? 'green' : 'red'

    const apiCall = async (terms, dupes)=> {
        result = await axios.get(`http://localhost:8080/search?terms=${ terms }&dupes=${ dupes }`)
        let div = document.getElementById('names')
        let output = ''

        result.data.forEach((name)=> {
            output += `<p>${ name }</p>`
        })
        div.innerHTML = output
    }

    input.addEventListener('keyup', async (event)=> {
        let terms = event.target.value
        await apiCall(terms, dupes.checked)
    })

    dupes.addEventListener('change', async (event)=> {
        let terms = input.value
        allowDupes.innerText = event.target.checked === true ? 'true' : 'false'
        allowDupes.style.color = event.target.checked === true ? 'green' : 'red'

        await apiCall(terms, event.target.checked)
    })
})()