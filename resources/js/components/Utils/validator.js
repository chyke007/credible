/* eslint-disable */
const isEmail = email => {
    const regEx = /[a-z0-9\._%+!$&*=^|~#%'`?{}/\-]+@([a-z0-9\-]+\.){1,}([a-z]{2,16})/;
    if (email.match(regEx)) return true;
    else return false;
};
const isEmpty = string => {
    if (!string) return true;
    if (string.trim() === "") return true;
    else return false;
};

const isEqual = (string1, string2) => {
    if (string1 === string2) return true;
    else return false;
};

const isLessThan = (string, len) => {
    if (string.length < len) return true;
    else return false;
};

const isLessThanN = (num, len) => {
    if (Number(num) < len) return true;
    else return false;
};

exports.validateRegisterData = data => {
    let errors = {};

    if (isEmpty(data.email)) {
        errors.email = "Email must not be empty";
    } else if (!isEmail(data.email)) {
        errors.email = "Email be a valid email address";
    }
    if (isLessThan(data.fname, 3))
        errors.fname = "Frst name must be more than 3 characters";
    if (isEmpty(data.fname)) errors.fname = "First Name must not be empty";
    if (isLessThan(data.sname, 3))
        errors.sname = "Last Name must be more than 3 characters";
    if (isEmpty(data.sname)) errors.sname = "Last Name must not be empty";
    if (isEmpty(data.password)) errors.passsword = "Password must not be empty";
    if (isEmpty(data.rpassword))
        errors.rpassword = "Repeat Password must not be empty";
    if (!isEqual(data.password, data.rpassword))
        errors.match = "Password must match";
    if (isLessThan(data.password, 7))
        errors.pass_l = "Password must be more than 6 characters";

    return {
        errors,
        valid: Object.keys(errors).length === 0 ? true : false
    };
};

exports.validateLoginData = data => {
    let errors = {};

    if (isEmpty(data.email)) {
        errors.email = "Email must not be empty";
    } else if (!isEmail(data.email)) {
        errors.email = "Email be a valid email address";
    }
    if (isEmpty(data.password)) errors.password = "Password must not be empty";
    if (isLessThan(data.password, 6))
        errors.password = "Password must not be less than 5 characters";

    return {
        errors,
        valid: Object.keys(errors).length === 0 ? true : false
    };
};
