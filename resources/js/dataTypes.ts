export class FormFieldItem {
    name: string;
    type: string;
    label: string;
    placeholder: string;
    options: Array<any>;

    constructor(name: string, label: string, type: string = "text", placeholder: string = "", options: any = []) {
        this.name = name;
        this.type = type;
        this.label = label;
        this.placeholder = placeholder;
        this.options = options
    }
}
