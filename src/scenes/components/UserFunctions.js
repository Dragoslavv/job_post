
export const createUsers = (title,description,email) => {

    return fetch("http://senzations-api.com/?url=posts",{
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: "title="+ title +"&description="+description+"&email="+ email
    }).then((response) =>
        response.json()
    ).then((data) => {

        return data;

    }).catch(function (err) {
        return err;
    });
};


export const read = () => {

    return fetch("http://senzations-api.com/?url=read",{
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
    }).then((response) =>
        response.json()
    ).then((data) => {

        return data;

    }).catch(function (err) {
        return err;
    });
};