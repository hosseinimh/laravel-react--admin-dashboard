import * as yup from "yup";
import { validation, loginPage as strings } from "../../../constants/strings";

const loginSchema = yup.object().shape({
    email: yup
        .string(validation.stringMessage.replace(":field", strings.email))
        .max(
            50,
            validation.maxMessage
                .replace(":field", strings.email)
                .replace(":max", "50")
        )
        .email(validation.emailMessage.replace(":field", strings.email))
        .required(validation.requiredMessage.replace(":field", strings.email)),
    password: yup
        .string(validation.stringMessage.replace(":field", strings.password))
        .min(
            4,
            validation.minMessage
                .replace(":field", strings.password)
                .replace(":min", "4")
        )
        .max(
            4,
            validation.maxMessage
                .replace(":field", strings.password)
                .replace(":max", "4")
        )
        .required(
            validation.requiredMessage.replace(":field", strings.password)
        ),
});

export default loginSchema;
