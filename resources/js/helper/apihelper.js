import axios from 'axios';

const apiHelper = axios.create({
    baseURL: '', // Replace with your API base URL
});

export function fetchUserHrRoles() {
    return new Promise((resolve, reject) => {
        apiHelper.get('fetch_user_hr_roles')
            .then(response => {
                resolve(response.data);
                // console.log(response.data)
            })
            .catch(error => {
                console.log(error.response.data.message)
                reject(error.response.data.message)
                // reject(error);
            });
    });
}

// Add other helper functions here if needed
export function fetchDepartment() {
    return new Promise((resolve, reject) => {
        apiHelper.get('department_detail')
            .then(response => {
                resolve(response.data);
                localStorage.setItem('department_detail', JSON.stringify(response.data))
            })
            .catch(error => {
                console.log(error.response.data.message)
                reject(error.response.data.message)
                // reject(error);
            });
    });
}
export function overall_designation() {
    return new Promise((resolve, reject) => {
        apiHelper.get('overall_designation')
            .then(response => {
                resolve(response.data);
                localStorage.setItem('overall_designation', JSON.stringify(response.data))

                // console.log(response.data)
            })
            .catch(error => {
                console.log(error.response.data.message)
                reject(error.response.data.message)
                // reject(error);
            });
    });
}

export function overall_location() {
    return new Promise((resolve, reject) => {
        apiHelper.get('overall_location')
            .then(response => {
                resolve(response.data);
                localStorage.setItem('overall_location', JSON.stringify(response.data))

                // console.log(response.data)
            })
            .catch(error => {
                console.log(error.response.data.message)
                reject(error.response.data.message)
                // reject(error);
            });
    });
}
export function overall_empcode() {
    return new Promise((resolve, reject) => {
        apiHelper.get('overall_empcode')
            .then(response => {
                resolve(response.data);
                // console.log(response.data)
            })
            .catch(error => {
                console.log(error.response.data.message)
                reject(error.response.data.message)
                // reject(error);
            });
    });
}
export function getHrSeesion() {
    return new Promise((resolve, reject) => {
        apiHelper.get('session_not_in_dist')
            .then(response => {
                resolve(response.data);
                localStorage.setItem('hr_session',  response.data)
                localStorage.getItem('hr_session')
            })
            .catch(error => {
                console.log(error.response.data.message)
                reject(error.response.data.message)
                // reject(error);
            });
    });
}


export default apiHelper;
