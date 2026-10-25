import { useState } from 'react';

function formatCurrency(value) {
    return `$${Number(value ?? 0).toFixed(2)}`;
}

export default function RecentQuotes({ quotes }) {
    const [list] = useState(quotes);

    if (!list.length) {
        return (
            <div className="dashboard-empty">
                <i className="fas fa-file-invoice"></i>
                No quotes yet — create your first one to see it here.
            </div>
        );
    }

    return (
        <table className="table table-hover dashboard-table mb-0">
            <thead>
                <tr>
                    <th>Quote No.</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th className="text-end">Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {list.map((quote) => (
                    <tr key={quote.id}>
                        <td><span className="quote-number">{quote.quote_number}</span></td>
                        <td>{quote.customer_name}</td>
                        <td>{quote.quote_date}</td>
                        <td className="text-end fw-bold">{formatCurrency(quote.total)}</td>
                        <td className="text-end">
                            <a href={quote.show_url} className="btn btn-sm btn-outline-primary" title="View Quote">
                                <i className="fas fa-eye"></i>
                            </a>
                            <a href={quote.pdf_url} className="btn btn-sm btn-outline-primary" title="Download Quote PDF">
                                <i className="fas fa-download"></i>
                            </a>
                            {quote.invoice_pdf_url && (
                                <a href={quote.invoice_pdf_url} className="btn btn-sm btn-outline-primary" title="Download Invoice PDF">
                                    <i className="fas fa-file-invoice-dollar"></i>
                                </a>
                            )}
                        </td>
                    </tr>
                ))}
            </tbody>
        </table>
    );
}
