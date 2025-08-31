import Kenat, { toEC } from 'kenat';

// Convert Gregorian to Ethiopian
const etDate = toEC(2025, 9, 10); // August 18, 2025
const shortFormat = `${etDate.day}/${etDate.month}/${etDate.year}`;

console.log("Short Ethiopian Date:", shortFormat);
