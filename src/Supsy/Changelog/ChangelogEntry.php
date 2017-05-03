<?php

namespace Supsy\Changelog;

/**
 * ChangelogEntry
 *
 */
class ChangeLogEntry
{
    
    const UNRELEASED_PATH = 'changelogs/unreleased';
    
    protected $options;    
    
    public function __construct($options) {
        $this->options = $options;
    }
    
    public function create() {
        if($this->getBranchName() == "master") {
            throw \Exception("Create a branch first!");
        }
        
        if(file_exists($this->getFilePath())) {
            throw \Exception($filename." already exists! Use `--force` to overwrite.");
        }
        

    }
    
    protected function getFilePath() {
        $fileName = preg_replace('[^\w-]', '-', $this->getBranchName());
        $filePath = sprintf("%s/%s.yml", self::UNRELEASED_PATH, $fileName);

        return $filePath;
    }
    
    protected function getBranchName() {
        $output = system('git symbolic-ref --short HEAD');
        
        return trim($output);
    }
    
    protected function getTitle() {
        $title = implode('\r\n', $this->options->getArguments());
        
        if (strlen($title) > 1 ) {
            return $title;
        } elseif($this->options['ammend']) {
            return $this->getLastCommitSubject();
        } else {
            throw \Exception('Provide a title for the changelog entry or use `--amend` to use the title from the previous commit.');
        }
    }
    
    protected function getLastCommitSubject() {
        $output = system('git log --format="%s" -1');
        
        return trim($output);
    }
}
