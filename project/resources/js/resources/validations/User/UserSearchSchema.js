import * as yup from "yup";
import { validation, usersPage as strings } from "../../../constants/strings";

const userSearchSchema = yup.object().shape({
    email: yup
        .string(validation.stringMessage.replace(":field", strings.email))
        .max(
            50,
            validation.maxMessage
                .replace(":field", strings.email)
                .replace(":max", "50")
        ),
    nameFamily: yup
        .string(validation.stringMessage.replace(":field", strings.nameFamily))
        .max(
            50,
            validation.maxMessage
                .replace(":field", strings.nameFamily)
                .replace(":max", "50")
        ),
});

export default userSearchSchema;
