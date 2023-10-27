<?php
namespace App\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ServiceCategory;
use App\Models\Staff;
use App\Models\Store;
use App\Models\Supplier;
use stdClass;

class Expenses extends BaseController {
    
    protected $_expenseModel, $_staffModel, $_personModel, $_supplierModel, $_expenseCategoryModel, $_storeModel;
    protected $_session, $_userID, $_userData, $_expenseCategories, $_db;

    public function initController($request, $response, $logger)
	{
		parent::initController($request, $response, $logger);

		// instantiate our model, if needed
        
        $this->_expenseModel = new Expense();
        $this->_staffModel = new Staff();
        $this->_expenseCategoryModel = new ExpenseCategory();
                
        $this->_expenseCategories = $this->getCategories();

		
	}
    
    function index()
    {
        $data['controller_name'] = 'Expenses';

        $data['categories'] = $this->_expenseCategories;                    
        echo View('expenses/manage', $data);
    }

    
    function view($expenseID = -1){

        $data['controller_name'] = 'Expenses';
        $data['expense_category'] = $this->request->getPost('category');
        $data['categories'] = $this->_expenseCategories;
        $data['expenseID'] = $expenseID;
        
        echo View('expenses/form', $data);

    }

    function save($expenseID = -1){

        $expense_data = array(            
            'name' => $this->request->getPost('name'),
            'category' => $this->request->getPost('category'),            
            'description' => $this->request->getPost('description'),
            'amount' => $this->request->getPost('amount'),
            'addedBy' => $this->request->getPost('addedBy'),
            'date' => strtotime($this->request->getPost('date')),
            'supplier' => $this->request->getPost('supplier')
        );
        if ($expenseID > 0) {
            $expense_data['$expenseID'] = $expenseID;
        }

        if ($this->_expenseModel->save($expense_data)) {
            echo json_encode(['success' => true, 'message' => 'expense added successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'There was a problem updating the expense']);
        }

    }
    
    public function getCategories()
    {
        $builder = $this->_expenseCategoryModel->select('expense_categories.categoryID, expense_categories.name');
                        
        
        $categories = $builder->findAll();
        
        return $categories;
    }

    public function getCategories4Table()
    {
       
        $categories = $this->getCategories();
        
        $format_result = [];  $index = 1;
        
        foreach ($categories as $category) {
            
           $format_result[] = [$category->categoryID, $index, $category->name,  "No Department"];
           
           $index++;
        }
        
        echo json_encode($format_result);
    }

    
    public function saveCategory($categoryID = -1)
    {
        
        $categoryID = $this->request->getPost('categoryID');
        
        $categoryData = [
            'name' => $this->request->getPost('category_name'),
            'departmentID' => $this->request->getPost('departmentID'),
            'addedBy' =>config('loggedInStaff')->staffID,
        ];
                
        if($categoryID > 0) $categoryData['categoryID'] = $categoryID; // Update Existing Categories
            
        if ($this->_expenseCategoryModel->save($categoryData)){
            
            echo json_encode(array('success' => true, 'message' => 'Categories updated successfully', 'categoryID' => $categoryID));
            
        }else{
            echo json_encode(array('success' => false, 'message' => 'Error while updating category', 'categoryID' => -1));
        }
        
    }
    
    function deleteCategory()
    {        
        $CategoriesToDelete = $this->request->getPost('ids');

        if ($this->_expenseCategoryModel->where('categoryID', $CategoriesToDelete)->delete())
        {
            echo json_encode(array('success' => true, 'message' => "Category successfully deleted !"));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => "Category cannot be deleted"));
        }
    }

    function getAll($start_time = "", $end_time = "")
    {   
        $expenses = $this->_expenseModel->select('expenses.*, IFNULL(expense_categories.name, "No Category") as categoryName')
                        ->where('date >=', $start_time)
                        ->where('date <', $end_time)
                        ->join('expense_categories', 'expenses.category = expense_categories.categoryID', 'LEFT')
                        ->orderBy('date', 'DESC')
                    ->findAll();

        $format_result = [];

        $format_result['table_data'] = [];

        foreach ($expenses as $expense)
        {            
            $format_result['table_data'][] = array(

                $expense->expenseID,

                substr(ucwords($expense->name), 0, 40),

                to_currency($expense->amount, true , 0),

                ucwords($expense->categoryName),

                date("d M, Y H:i A", $expense->date)
            );
        }
        
        $monthlyTotal = $this->_expenseModel->selectSum('amount')->where('date >=', strtotime(date('Y-m-01')))->where('date <', strtotime(date('Y-m-t')))->first();

        $format_result['monthly_total'] = to_currency($monthlyTotal->amount, true, 0);
        
        
        $prev = strtotime('yesterday') - (24*60*60); // 2 days ago
        $yester = strtotime('yesterday'); // 1 day ago
        $today = strtotime('today'); // today
        $tomorrow = strtotime('tomorrow'); // tomorrow

        $previousDay = $this->_expenseModel->selectSum("amount")->where('date >=', $prev)->where('date <=', $yester - 1)->first()->amount;

        $yesterday = $this->_expenseModel->selectSum("amount")->where("date >= ", $yester)->where("date <= ", $today - 1)->first()->amount;

        $today = $this->_expenseModel->selectSum("amount")->where("date >= ", $today)->where("date <= ", $tomorrow - 1)->first()->amount;

        if ($previousDay == null) $previousDay = 0; 
        if ($yesterday == null) $yesterday = 0; 
        if ($today == null) $today = 0; 

        $format_result['daily_stats'] = json_encode(array($previousDay, $yesterday, $today), JSON_NUMERIC_CHECK);

        echo json_encode($format_result);
        exit;
    }

    function getRow($expenseID = -1)
    {
        $expense = $this->_expenseModel->find( $expenseID);
        
        $expense->formattedDate = date("d F Y h:i A", $expense->date);

        echo json_encode($expense);
        exit;
    }

    function delete()
    {
        $expenses_to_delete = $this->request->getPost('ids');
        
        if ($this->_expenseModel->delete($expenses_to_delete))
        {
            echo json_encode(array('success' => true, 'message' => 'Expense deleted successfully'));
        }
        else
        {
            echo json_encode(array('success' => false, 'message' => 'Sorrry, this Expense cannot be deleted!'));
        }
        
    }

}

?>