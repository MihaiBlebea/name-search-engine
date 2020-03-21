const search = async ()=> {
    return await axios.get('http://localhost:8080/search?terms')
}