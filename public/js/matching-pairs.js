let pairCount = 3;

function addPair() {
    if (pairCount >= 10) {
        alert('Maksimal 10 pasangan!');
        return;
    }

    pairCount++;
    const container = document.getElementById('pairs-container');
    const pairDiv = document.createElement('div');
    pairDiv.className = 'pair-item';
    pairDiv.style.cssText = 'background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e2e8f0;';

    pairDiv.innerHTML = `
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
            <strong style="color: #475569;">Pasangan ${pairCount}</strong>
            <button type="button" onclick="removePair(this)" style="background: #ef4444; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                ✕ Hapus
            </button>
        </div>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
            <div>
                <label style="font-size: 14px; color: #64748b;">Kata/Kalimat 1</label>
                <input type="text" name="pairs[${pairCount - 1}][word1]" required placeholder="Contoh: Dog" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>
            <div>
                <label style="font-size: 14px; color: #64748b;">Pasangannya</label>
                <input type="text" name="pairs[${pairCount - 1}][word2]" required placeholder="Contoh: Anjing" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>
        </div>
    `;

    container.appendChild(pairDiv);
}

function removePair(button) {
    const pairItems = document.querySelectorAll('.pair-item');
    if (pairItems.length <= 3) {
        alert('Minimal 3 pasangan!');
        return;
    }

    button.closest('.pair-item').remove();
    pairCount--;

    // Update numbering
    const items = document.querySelectorAll('.pair-item');
    items.forEach((item, index) => {
        const strong = item.querySelector('strong');
        if (strong) {
            strong.textContent = `Pasangan ${index + 1}`;
        }
        // Update input names
        const inputs = item.querySelectorAll('input');
        if (inputs[0]) inputs[0].name = `pairs[${index}][word1]`;
        if (inputs[1]) inputs[1].name = `pairs[${index}][word2]`;
    });
}
