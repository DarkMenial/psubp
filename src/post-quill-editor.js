const quill = new Quill("text-editor", {
    modules: {
        toolbar: {
            container: [
                [{ header: [1, 2, 3, 4, false] }],
                ["bold", "image", "blockqoute", "code-block"],
                [{ lists: "ordered" }, { list: "bullet" }],
            ],
            handlers: {
                image: selectLocalImage,
            },
        },
    },
    placeholder: "",
    theme: "snow",
});