export class FormFieldItem {
    name: string;
    type: string;
    label: string;
    placeholder: string;

    constructor(name: string, label: string, type: string = "text", placeholder: string = "") {
        this.name = name;
        this.type = type;
        this.label = label;
        this.placeholder = placeholder;
    }
}
