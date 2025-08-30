let option_arr = []
let js_code = "%wd$43&o=13d?l="
function add_option() {
    let option = document.getElementById('option').value
    console.log("option: '"+option+"'");
    if ( option !== '') {
        let span = document.createElement('span')
        span.setAttribute('name', option)
        span.setAttribute('id', option)
        span.innerText = option
        let br = document.createElement('br')
        br.setAttribute('id', option + '0')
        let bs4 = document.createElement('input')
        bs4.setAttribute('type', 'radio')
        bs4.setAttribute('value', option)
        bs4.setAttribute('name', 'optcore')
        bs4.setAttribute('class', 'radiox')
        bs4.innerText = option
        option_arr.push(option)
        document.getElementById('options').appendChild(bs4);
        document.getElementById('options').appendChild(span);
        document.getElementById('options').appendChild(
            br
        )
        document.getElementById('namespace').value = option_arr.join(js_code);
    }
    else
    {
        alert("لطفا کادر گزینه را پر کنین")
    }
}
function remove_option() {
    let cls = document.getElementsByClassName('radiox')
    console.log(cls)
    for (let i = 0; i < cls.length; i++) {
        el = cls[i]
        if (el.checked) {
            let span = document.getElementById(el.getAttribute('value'))
            let br = document.getElementById(el.getAttribute('value') + '0')
            document.getElementById('options').removeChild(span);
            document.getElementById('options').removeChild(el);
            document.getElementById('options').removeChild(br)
            option_arr.splice(option_arr.indexOf(el.getAttribute('value')), 1);
            document.getElementById('namespace').value = option_arr.join(js_code)
        }
    }
}

let del_array = [];

function addlist(id) {
    if (
        document.getElementById(id).getAttribute('selected') == 'false'
    ) {
        del_array.push(id)
        document.getElementById(id).setAttribute('selected', 'true')
        document.getElementById(id).style.backgroundColor = "rgb(0,0,0)"
        document.getElementById(id).style.color = "rgb(255,255,255)"
        document.getElementById('del').value = del_array.join(js_code)
    }
    else {
        document.getElementById(id).setAttribute('selected', 'false')
        del_array.splice(del_array.indexOf(id), 1)
        document.getElementById(id).style.backgroundColor = "rgb(210,210,210)"
        document.getElementById(id).style.color = "rgb(0,0,0)"
        document.getElementById('del').value = del_array.join(js_code)
    }


}

