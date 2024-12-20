<?php
function getExcludedPaths($directory) {
    $exclude = ['.idea', '.vscode', '.gitignore', '.git'];
    $gitignoreFile = $directory . '/.gitignore';

    if (is_readable($gitignoreFile)) {
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

    if (!is_dir($directory) || !is_readable($directory)) {
        return [];
    }

    foreach (new DirectoryIterator($directory) as $file) {
        if ($file->isDot()) continue;

        $filePath = $file->getPathname();
        $relativePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);

        if (strpos($filePath, $_SERVER['DOCUMENT_ROOT']) !== 0) {
            continue;
        }

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
                'name' => htmlspecialchars($file->getBasename()),
                'path' => htmlspecialchars($relativePath),
                'children' => listFilesAndFolders($filePath, $exclude)
            ];
        } else {
            $items[] = [
                'type' => 'file',
                'name' => htmlspecialchars($file->getBasename()),
                'path' => htmlspecialchars($relativePath)
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

if (is_readable('main.html')) {
    include 'main.html';
} else {
    echo 'Error: main.html not found or unreadable.';
}
?>
