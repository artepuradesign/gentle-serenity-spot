import { Home, CreditCard, ShoppingBag, User } from "lucide-react";

const navItems = [
  { icon: Home, label: "Início", active: true },
  { icon: CreditCard, label: "Cartão", active: false },
  { icon: ShoppingBag, label: "Shopping", active: false },
  { icon: User, label: "Perfil", active: false },
];

const PainelBottomNav = () => (
  <nav className="fixed bottom-0 left-0 right-0 z-50 bg-background border-t border-border">
    <div className="max-w-md mx-auto flex items-center justify-around py-2">
      {navItems.map((item, i) => (
        <button key={i} className="flex flex-col items-center gap-0.5 px-4 py-1">
          <item.icon className={`h-6 w-6 ${item.active ? "text-primary" : "text-muted-foreground"}`} />
          <span className={`text-[10px] font-body ${item.active ? "text-primary font-bold" : "text-muted-foreground"}`}>
            {item.label}
          </span>
        </button>
      ))}
    </div>
  </nav>
);

export default PainelBottomNav;
