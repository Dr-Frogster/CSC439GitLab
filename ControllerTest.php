<?php
require_once 'Main.php';

use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{   
    private $model;
    private $view;
    private $sut;
    
    public function setUp() :void {
        $d = new YahtzeeDice();
        $this->model = new Yahtzee($d);
        $this->view = $this->createStub(YahtzeeView::class);
        $this->sut = new YahtzeeController($this->model, $this->view);
    } 
    /**
    * @covers \YahtzeeController::get_model
    */
    public function test_get_model(){
        $result = $this->sut->get_model();
        $this->assertNotNull($result);
    }
    /**
    * @covers::get_view
    */
    public function test_get_view(){
        $result = $this->sut->get_view();
        $this->assertNotNull($result);
    }
    
    public function test_get_possible_categories() {
        $result = $this->sut->get_possible_categories();

        $expectedCategories = [
            'ones' => 0,
            'twos' => 0,
            'threes' => 0,
            'fours' => 0,
            'fives' => 0,
            'sixes' => 0,
            'three_of_a_kind' => 0,
            'four_of_a_kind' => 0,
            'full_house' => 0,
            'small_straight' => 0,
            'large_straight' => 0,
            'chance' => 0,
            'yahtzee' => 0,
        ];

        $this->assertEquals($expectedCategories, $result);
    }

    
    public function test_process_keep_input_exit(){
        //checks for exit and q
        $result = $this->sut->process_keep_input("exit");
        $this->assertEquals(-1,$result);
        $result = $this->sut->process_keep_input("q");
        $this->assertEquals(-1, $result);
       //checks for all
        $result = $this->sut->process_keep_input("all");
        $this->assertEquals(0, $result);
        //checks for none, pass and blank
        $result = $this->sut->process_keep_input("none");
        $this->assertEquals(-2, $result);
        $result = $this->sut->process_keep_input("pass");
        $this->assertEquals(-2, $result);
        $result = $this->sut->process_keep_input("");
        $this->assertEquals(-2, $result);
    }

    public function test_process_score_input(){

        $result = $this->sut->process_score_input("exit");
        $this->assertEquals(-1, $result);
        $result = $this->sut->process_score_input("q");
        $this->assertEquals(-1, $result);


        $this->model->roll(5); 
        $result = $this->sut->process_score_input("ones");
        $this->assertEquals(0, $result);
        $this->assertNotNull($this->model->get_scorecard()["ones"]);

        $this->model->clear_kept_dice();
        $result = $this->sut->process_score_input("invalid_category");
        $this->assertEquals(-2, $result);
        
         $this->assertEquals($this->sut->process_score_input("invalid_category"), -2);
    
    $this->sut->update_scorecard("ones", 3); // Set a valid score for testing
    $this->assertEquals($this->d->process_score_input("ones"), 0); 

    }
    public function test_main_loop(){
        //$startvalue = $this->view->output_turn();
        //$this->sut->main_loop();
        //$this->assertEquals($startvalue + 13, $this->view->output_turn());
        $result = $this->sut->handle_roll();
        $this->assertEquals(-1, $result);
    }
}
?>