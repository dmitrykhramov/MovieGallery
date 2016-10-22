<?php

class SiteController {
    
    // Action for main page
    public function actionIndex() {
        
        $categories = Category::getCategoriesList();
        
        $latestMovies = Movie::getLatestMovies();
        
        $sliderMovies = Movie::getMostPopularMovies();
                      
        require_once(ROOT . '/views/site/index.php');
                
        return true;
    }
    
    // Action for page contacts
    public function actionContact() {
                
        // Variables for the form
        $userEmail = '';
        $userText = '';
        $subject = '';
        $result = false;
        
        if (isset($_POST['submit'])) {
            
            // If form is sent get info from the form
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
            $subject = $_POST['Subject'];
    
            $errors = false;
                        
            // Vakidation
            if (!User::checkEmail($userEmail)) {
                $errors[] = 'Incorrect email';
            }
            
            // If no errors - send e-mail to admin
            if ($errors == false) {
                $adminEmail = 'dmitrii.hramov@mail.ru';
                $message = "Text: {$userText}. From {$userEmail}";
                $result = mail($adminEmail, $subject, $message);
                $result = true;
            }

        }
        
        require_once(ROOT . '/views/site/contact.php');
        
        return true;
    }
    
    public function actionSearch() {
                
        if (isset($_POST['search'])) {
        
            $words = $_POST['words'];
            $table = $_POST['filter'];
            
            $errors = false;
            
             if (empty($words)) {
                $errors[] = 'Empty request was sent'; 
            }
            
            else if (strlen($words) < 2 || strlen($words) > 64) {
                $errors[] = 'Search request should be from 3 to 64 characters'; 
            }
                       
            else {
                $searchResults = Search::getSearch($words, $table);
            }
                
        }
                 
        require_once(ROOT . '/views/search/index.php');
                        
        return true;
    }
    
    
}
