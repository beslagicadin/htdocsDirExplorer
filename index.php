<?php
function getExcludedPaths($directory) {
    $exclude = ['.idea', '.vscode'];
    $gitignoreFile = $directory . '/.gitignore';
    if (file_exists($gitignoreFile)) {
        $lines = file($gitignoreFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line[0] !== '#' && $line !== '') {
                $exclude[] = $line;
            }
        }
    }
    return $exclude;
}

function listFilesAndFolders($directory, $exclude) {
    $items = [];
    foreach (new DirectoryIterator($directory) as $file) {
        if ($file->isDot()) continue;

        $filePath = $file->getPathname();
        $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);

        $excludeItem = false;
        foreach ($exclude as $excluded) {
            if (fnmatch($excluded, $file->getBasename()) || strpos($filePath, DIRECTORY_SEPARATOR . $excluded) !== false) {
                $excludeItem = true;
                break;
            }
        }
        if ($excludeItem) continue;

        if ($file->isDir()) {
            $items[] = [
                'type' => 'dir',
                'name' => $file->getBasename(),
                'path' => $relativePath,
                'children' => listFilesAndFolders($filePath, $exclude)
            ];
        } else {
            $items[] = [
                'type' => 'file',
                'name' => $file->getBasename(),
                'path' => $relativePath
            ];
        }
    }
    return $items;
}

function renderStructure($items) {
    if (empty($items)) return '';
    $output = '<ul>';
    foreach ($items as $item) {
        if ($item['type'] === 'dir') {
            $output .= '<li class="folder" onclick="toggleFolder(event)">';
            $output .= htmlspecialchars($item['name']);
            $output .= renderStructure($item['children']);
            $output .= '</li>';
        } else {
            $output .= '<li class="file">';
            $output .= '<a href="#" onclick="loadFileContent(\'' . htmlspecialchars($item['path']) . '\', event)">' . htmlspecialchars($item['name']) . '</a>';
            $output .= '</li>';
        }
    }
    $output .= '</ul>';
    return $output;
}

$htdocs = $_SERVER['DOCUMENT_ROOT'];
$exclude = getExcludedPaths($htdocs);
$fileStructure = listFilesAndFolders($htdocs, $exclude);

ob_start();
echo renderStructure($fileStructure);
$renderStructure = ob_get_clean();

include 'main.html';
?>
