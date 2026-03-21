<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Barryvdh\DomPDF\Facade\Pdf;



class FinanceController extends Controller
{
    public function index()
    {
        return view('admin.finance.index');
    }
    public function expenditure(Request $request)
{
    $categories = ExpenseCategory::orderBy('name')->get();

    $query = Expense::with('category')->latest();

    // Filter by category
    if ($request->filled('category_id')) {
        $query->where('expense_category_id', $request->category_id);
    }

    // Filter by payment mode
    if ($request->filled('payment_mode')) {
        $query->where('payment_mode', $request->payment_mode);
    }

    // Filter by date range
    if ($request->filled('from') && $request->filled('to')) {
        $query->whereBetween('expense_date', [$request->from, $request->to]);
    }

    $expenses = $query->get();

    return view('admin.finance.expenses', compact('categories', 'expenses'));
}

public function storeCategory(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:expense_categories,name',
    ]);

    ExpenseCategory::create([
        'name' => $request->name,
    ]);

    return back()->with('success', 'Category created successfully');
}
public function storeExpense(Request $request)
{
    $request->validate([
        'expense_category_id' => 'required|exists:expense_categories,id',
        'expense_date'        => 'required|date',
        'approved_by'         => 'required|string|max:255',
        'payee' => 'required|string', 
        'payment_mode'        => 'required|in:cash,upi,neft,rtgs,online,cheque',
        'amount'              => 'required|numeric|min:1',
        'notes'               => 'nullable|string',
    ]);

    Expense::create([
        'expense_category_id' => $request->expense_category_id,
        'expense_date'        => $request->expense_date,
        'approved_by'         => $request->approved_by,
         'payee' => $request->payee,
        'payment_mode'        => $request->payment_mode,
        'amount'              => $request->amount,
        'notes'               => $request->notes,
        'created_by'          => auth()->id(),
    ]);

    return back()->with('success', 'Expense added successfully');
}
public function downloadCsv(Request $request): StreamedResponse
{
    $query = Expense::query();

    // Optional filters
    if ($request->from_date) {
        $query->whereDate('expense_date', '>=', $request->from_date);
    }

    if ($request->to_date) {
        $query->whereDate('expense_date', '<=', $request->to_date);
    }

    $fileName = 'expenses-report-' . now()->format('Y-m-d') . '.csv';

    return response()->streamDownload(function () use ($query) {

        $handle = fopen('php://output', 'w');

        // CSV Header
        fputcsv($handle, [
            'Date',
            'Category',
            'Description',
            'Amount',
            'Payment Mode',
            'Created At'
        ]);

        $query->orderBy('expense_date')
            ->chunk(500, function ($expenses) use ($handle) {
                foreach ($expenses as $expense) {
                    fputcsv($handle, [
                        $expense->expense_date,
                        $expense->category,
                        $expense->description,
                        $expense->amount,
                        $expense->payment_mode,
                        $expense->created_at->format('Y-m-d H:i'),
                    ]);
                }
            });

        fclose($handle);

    }, $fileName, [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
    ]);
}


}
