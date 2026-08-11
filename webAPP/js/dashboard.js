document.addEventListener('DOMContentLoaded', () => {
    /* ---- Mobile sidebar ---- */
    const sidebar = document.getElementById('sidebar');
    const scrim = document.getElementById('scrim');
    const menuBtn = document.getElementById('menuBtn');
    const openSide = () => { sidebar.classList.add('open'); scrim.classList.add('show'); };
    const closeSide = () => { sidebar.classList.remove('open'); scrim.classList.remove('show'); };
    if (menuBtn) menuBtn.addEventListener('click', openSide);
    if (scrim) scrim.addEventListener('click', closeSide);

    /* ---- Add project panel (client-side only) ---- */
    const addSection = document.getElementById('addProjectSection');
    const toggleBtn = document.getElementById('toggleAddProject');
    const cancelBtn = document.getElementById('cancelAddProject');
    const showAdd = () => {
        addSection.style.display = 'block';
        addSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        const f = document.getElementById('project_name'); if (f) f.focus();
    };
    if (toggleBtn) toggleBtn.addEventListener('click', showAdd);
    if (cancelBtn) cancelBtn.addEventListener('click', () => { addSection.style.display = 'none'; });

    const COLORS = 8;
    const initial = (s) => (s.trim()[0] || '?').toUpperCase();

    const form = document.getElementById('addProjectForm');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('project_name').value.trim();
            const deadline = document.getElementById('deadline').value;
            const members = document.getElementById('team_members').value
                .split(',').map(m => m.trim()).filter(Boolean);
            if (!name) return;

            const due = deadline
                ? new Date(deadline + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
                : '—';
            const key = 'PRJ-' + Math.random().toString(36).slice(2, 7).toUpperCase();

            const avatars = members.slice(0, 4).map((m, i) =>
                `<span class="avatar c${(i % COLORS) + 1}" style="--s:30px" title="${m}">${initial(m)}</span>`
            ).join('') + (members.length > 4
                ? `<span class="avatar" style="--s:30px;background:#94a3b8">+${members.length - 4}</span>` : '');

            const card = document.createElement('article');
            card.className = 'project-card';
            card.style.opacity = '0';
            card.innerHTML = `
                <div class="pc-top">
                    <div>
                        <div class="pc-title">${name}</div>
                        <div class="pc-key">${key}</div>
                    </div>
                    <span class="badge badge-amber">Pending</span>
                </div>
                <div class="pc-meta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4.5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v3M16 3v3"/></svg>
                    Due ${due}
                </div>
                <div>
                    <div class="pc-prog-label"><span>Progress</span><span>15%</span></div>
                    <div class="progress g-amber"><span style="width:15%"></span></div>
                </div>
                <div class="pc-foot">
                    <div class="avatar-stack">${avatars || '<span class="avatar" style="--s:30px;background:#cbd5e1">?</span>'}</div>
                    <span class="menu-dots"><svg viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg></span>
                </div>`;

            let grid = document.getElementById('projectGrid');
            if (!grid) {
                grid = document.createElement('div');
                grid.className = 'project-grid';
                grid.id = 'projectGrid';
                document.getElementById('projects').appendChild(grid);
            }
            grid.prepend(card);
            requestAnimationFrame(() => { card.style.transition = 'opacity .4s ease'; card.style.opacity = '1'; });

            form.reset();
            addSection.style.display = 'none';
        });
    }
});
