import { fetchDepartment } from './apihelper';
import { overall_designation } from './apihelper';
import { overall_location } from './apihelper';
export function capitalize(str) {
    // Capitalize the first letter of the given string
    return str.charAt(0).toUpperCase() + str.slice(1);
}
export function getItem(str) {
    // Capitalize the first letter of the given string
    return localStorage.getItem(str);
}
export function hasPermission(permission) {
  // Retrieve permissions from localStorage or wherever you store them
  const permissions = JSON.parse(localStorage.getItem('permissions')) || [];
  return permissions.includes(permission);
}
// export function errorCatch(message) {
//     // Capitalize the first letter of the given string
//     return
// }
export function validateDateRange(startDate, endDate) {
    if (startDate === '' || endDate === '') {
      return {
        isValid: false,
        error: "Please select both Start Date and End Date."
      };
    }

    if (startDate > endDate) {
      return {
        isValid: false,
        error: "End Date cannot be before Start Date."
      };
    }

    return {
      isValid: true,
      error: ""
    };
  }

  export async function checkLocal(name){
    if(name==='department_detail'){
        if(getItem(name) == null ?? getItem(name) === ''){
            // console.log(fetchDepartment)
            await fetchDepartment()

            return JSON.parse(getItem(name));
        }
        else{
            return JSON.parse(getItem(name));
        }
    }else if(name === 'overall_designation'){
        if(getItem(name) == null ?? getItem(name) === ''){
            // console.log(fetchDepartment)
            await overall_designation()
            return JSON.parse(getItem(name));
        }
        else{
            return JSON.parse(getItem(name))
        }
    }
    else if (name ==='overall_location'){
        if(getItem(name) == null ?? getItem(name) === ''){
            // console.log(fetchDepartment)
            await overall_location()
            return JSON.parse(getItem(name));
        }
        else{
            return JSON.parse(getItem(name));
        }
    }

}
