<?php

namespace Supsy\Changelog;

use Symfony\Component\Yaml\Yaml;

/**
 * ChangelogEntry
 *
 */
class ChangelogEntry
{
    
    const UNRELEASED_PATH = 'changelogs/unreleased';
    const TYPES = array(
        'added' => 'New feature',
        'fixed' => 'Bug fix',
        'changed' => 'Feature change',
        'deprecated' =>  'New deprecation',
        'removed' => 'Feature removal',
        'security' => 'Security fix',
        'performance' => 'Performance improvement',
        'other' => 'Other',
    );
    
    protected $options;    
    
    public function __construct($options) {
        $this->options = $options;
    }
    
    public function create() {
        if($this->getBranchName() == "master") {
            throw new \Exception("Create a branch first!");
        }
        
        if(file_exists($this->getFilePath()) && !isset($this->options['force'])) {
            throw new \Exception($this->getFilePath()." already exists! Use `--force` to overwrite.");
        }

        print "\e[32mcreate\e[0m ".$this->getFilePath()."\n";
        print $this->getContent();
        
        if(!isset($this->options['dry-run'])) {
            $this->write();
        }
        if(isset($this->options['amend'])) {
            $this->amend();
        }
    }
    
    protected function getFilePath() {
        $fileName = preg_replace('/[^\w-]/', '-', $this->getBranchName());
        $filePath = sprintf("%s/%s.yml", self::UNRELEASED_PATH, $fileName);

        return $filePath;
    }
    
    protected function write() {
        if (!file_exists(self::UNRELEASED_PATH)) {
            mkdir(self::UNRELEASED_PATH, 0755, true);
        }
        file_put_contents($this->getFilePath(), $this->getContent());
    }
    
    protected function getBranchName() {
        $output = exec('git symbolic-ref --short HEAD');
        
        return trim($output);
    }
    
    protected function getTitle() {
        $title = implode(' ', $this->options->getArguments());
        
        if (strlen($title) > 1 ) {
            return $title;
        } elseif(isset($this->options['amend'])) {
            return $this->getLastCommitSubject();
        } else {
            throw new \Exception('Provide a title for the changelog entry or use `--amend` to use the title from the previous commit.');
        }
    }
    
    protected function getLastCommitSubject() {
        $output = exec('git log --format="%s" -1');
        
        return trim($output);
    }
    
    protected function amend() {
        exec('git add '.$this->getFilePath());
        passthru('git commit --amend');
    }
    
    protected function getAuthor() {
        if (isset($this->options['git-username'])) {
            $output = exec('git config user.name');
        
            return trim($output);
        }
    }
    
    protected function getContent() {
        $content = array('title' => $this->getTitle());
        if (isset($this->options['merge-request'])) {
            $content['merge_request'] = $this->options['merge-request']->value;
        } else {
            $content['merge_request'] = "";
        }
        
        if ($this->getAuthor()) {
            $content['author'] = $this->getAuthor();
        } else {
            $content['author'] = "";
        }
        
        if (isset($this->options['type'])) {
            if (!in_array($this->options['type']->value, array_keys(static::TYPES))) {
                throw new \Exception(sprintf("Type not know, valid options are: %s", implode(', ', array_keys(static::TYPES))));
            }  
            $content['type'] = $this->options['type']->value;
        }
        
        return Yaml::dump($this->removeTrailingWhitespace($content));
    }
    
    protected function removeTrailingWhitespace($yamlContent) {
        
        return preg_replace('/ +$/', '', $yamlContent);
    }
}
