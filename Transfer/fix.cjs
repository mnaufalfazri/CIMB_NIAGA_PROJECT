const fs = require('fs');
const files = [
    'resources/js/pages/transfer/create.tsx',
    'resources/js/pages/transfer/confirm.tsx',
    'resources/js/pages/transfer/receipt.tsx',
    'resources/js/pages/transfer/history.tsx',
    'resources/js/pages/payment/create.tsx',
    'resources/js/pages/payment/confirm.tsx',
    'resources/js/pages/payment/receipt.tsx',
    'resources/js/pages/payment/history.tsx',
];

files.forEach(file => {
    let content = fs.readFileSync(file, 'utf8');
    
    const componentNameMatch = content.match(/export default function ([a-zA-Z0-9_]+)/);
    if (componentNameMatch) {
        const componentName = componentNameMatch[1];
        if (!content.includes(componentName + '.layout')) {
            content += `\n${componentName}.layout = (page: React.ReactNode) => page;\n`;
            fs.writeFileSync(file, content);
        }
    }
});
console.log('Fixed layouts!');
