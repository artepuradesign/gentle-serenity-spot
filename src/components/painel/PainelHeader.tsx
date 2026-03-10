import { Eye, EyeOff, HelpCircle, LogOut } from "lucide-react";

interface Props {
  inicialNome: string;
  primeiroNome: string;
  showBalance: boolean;
  onToggleBalance: () => void;
  onLogout: () => void;
}

const PainelHeader = ({ inicialNome, primeiroNome, showBalance, onToggleBalance, onLogout }: Props) => (
  <header className="nu-gradient-bg px-5 pt-12 pb-5">
    <div className="flex items-center justify-between">
      <div className="w-12 h-12 rounded-full bg-primary-foreground/20 flex items-center justify-center">
        <span className="text-primary-foreground text-lg font-heading font-bold">{inicialNome}</span>
      </div>
      <div className="flex items-center gap-5">
        <button className="text-primary-foreground/80 hover:text-primary-foreground transition-colors" onClick={onToggleBalance}>
          {showBalance ? <Eye className="h-6 w-6" /> : <EyeOff className="h-6 w-6" />}
        </button>
        <button className="text-primary-foreground/80 hover:text-primary-foreground transition-colors">
          <HelpCircle className="h-6 w-6" />
        </button>
        <button className="text-primary-foreground/80 hover:text-primary-foreground transition-colors" onClick={onLogout}>
          <LogOut className="h-6 w-6" />
        </button>
      </div>
    </div>
    <p className="text-primary-foreground text-lg mt-5 font-body">
      Olá, <span className="font-heading font-bold">{primeiroNome}</span>
    </p>
  </header>
);

export default PainelHeader;
