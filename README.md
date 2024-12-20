# /htdocs Dir Explorer / Project Viewer

## Overview
The **Project Viewer** is a web-based file explorer that dynamically displays the folder and file structure of the `htdocs` directory on your server. It allows users to preview file contents, including text and images, directly in the browser and navigate the folder structure interactively.

## Features
- Dynamically reads the folder and file structure of the `htdocs` directory.
- Excludes directories and files specified in `.gitignore`, `.idea`, and `.vscode` by default.
- Supports collapsing and expanding individual folders or all folders at once.
- Previews text files and images directly in the browser.
- Opens selected files in a new tab if required.
- Provides a responsive and user-friendly interface.

## File Structure
### Backend
- `index.php`: Main PHP file that generates the folder and file structure dynamically and renders it to the `main.html` template.
    - **Key functions**:
        - `getExcludedPaths($directory)`: Reads `.gitignore` and prepares a list of excluded files and folders.
        - `listFilesAndFolders($directory, $exclude)`: Recursively scans the directory structure and excludes unwanted files/folders.
        - `renderStructure($items)`: Renders the folder structure as nested HTML lists.

### Frontend
- `main.html`: The HTML template for rendering the file explorer UI.
- `styles.css`: Stylesheet for customizing the UI appearance.
- `script.js`: JavaScript file that provides interactivity.

## Usage
### Prerequisites
- A web server with PHP installed (e.g., Apache, Nginx).
- Place this project in the `htdocs` directory of your server.

### Installation
1. Clone the repository or copy the files to your server's `htdocs` directory.
2. Access the project via your browser by navigating to `http://localhost/htdocsDirExplorer`
(or your server's URL with custom extension).

### Customization
- **Exclude additional paths**: Add them to the `.gitignore` file or modify the `getExcludedPaths` function in `index.php`.
- **Customize styles**: Edit `styles.css`.
- **Enhance functionality**: Modify `script.js` for additional interactivity.

## Screenshots
1. **Main File Explorer Interface**:
    - Displays folder structure with buttons for collapsing/expanding all folders and clearing selection.

2. **File Content Viewer**:
    - Displays the content of text files or previews images when clicked.

## Technologies Used
- **Backend**: PHP
- **Frontend**: HTML, CSS, JavaScript

## Author
- [Adin Bešlagić](https://github.com/beslagicadin)

## License
This project is licensed under the GPL-3.0 license.

## Contributing
If you'd like to contribute:
1. Fork the repository.
2. Create a feature branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -m 'Add feature: "feature name"'`).
4. Push to the branch (`git push origin feature-name`).
5. Create a Pull Request.

## Contact
Feel free to connect with me on:
- [Email](mailto:beslagicadin@gmail.com)
- [GitHub](https://github.com/beslagicadin/)
- [LinkedIn](https://www.linkedin.com/in/beslagicadin/)
- [Facebook](https://www.facebook.com/beslagicadin/)
- [Instagram](https://www.instagram.com/beslagicadin/)

