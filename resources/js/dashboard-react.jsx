import { createRoot } from 'react-dom/client';
import RecentQuotes from './components/RecentQuotes.jsx';

const mountEl = document.getElementById('recent-quotes-root');

if (mountEl) {
    const quotes = JSON.parse(document.getElementById('recent-quotes-data').textContent);

    createRoot(mountEl).render(<RecentQuotes quotes={quotes} />);
}
