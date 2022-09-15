import axios from 'axios';

const token = document.querySelector('meta[name="csrf-token"]');
const postHeader = {'Content-Type': 'application/json', 'X-CSRF-TOKEN': token.content}
const getHeader = {'Content-Type': 'application/json'}
const storeRecordApi = '/api/store';
const getPropertiesApi = '/api/properties';
const getStudentDataApi = '/api/student/';
const getStudentsApi = '/api/students';
const updateRecordApi = '/api/update/';

export const getStudents = () => {
    return axios.get(getStudentsApi, { headers: getHeader });
};

export const studentData = (id) => {
    return axios.get(getStudentDataApi + id, { headers: getHeader });
};

export const storeRecord = (firstName, lastName, idNumber, country, dateOfBirth, registeredOn) => {
    let formData = new FormData();

    formData.append("first_name", firstName);
    formData.append("last_name", lastName);
    formData.append("identification_no", idNumber);
    formData.append("country", country);
    formData.append("date_of_birth", dateOfBirth);
    formData.append("registered_on", registeredOn);

    return axios.post(storeRecordApi, formData,{headers: postHeader});
};

export const updateRecord = (firstName, lastName, idNumber, country, dateOfBirth, registeredOn, id) => {
    let formData = new FormData();

    formData.append("first_name", firstName);
    formData.append("last_name", lastName);
    formData.append("identification_no", idNumber);
    formData.append("country", country);
    formData.append("date_of_birth", dateOfBirth);
    formData.append("registered_on", registeredOn);

    return axios.post(updateRecordApi + id, formData,{headers: postHeader});
};

export const getJobs = () => {
    return axios.get(getJobsApi, { headers: getHeader });
};
