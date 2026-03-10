import { Grid3X3, BarChart3, Users, CreditCard, QrCode, DollarSign, TrendingUp, Send, Settings, HeadphonesIcon } from "lucide-react";

const quickActions = [
  { icon: Grid3X3, label: "Área Pix" },
  { icon: Send, label: "Depositar" },
  { icon: Users, label: "Indique\namigos" },
  { icon: CreditCard, label: "Cartões" },
  { icon: QrCode, label: "QR Code" },
  { icon: BarChart3, label: "Pagar" },
  { icon: TrendingUp, label: "Investir" },
  { icon: DollarSign, label: "Empréstimo" },
  { icon: HeadphonesIcon, label: "Suporte" },
  { icon: Settings, label: "Ajustes" },
];

const PainelQuickActions = () => (
  <section className="px-5 pb-4">
    <div className="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
      {quickActions.map((action, i) => (
        <button key={i} className="flex flex-col items-center gap-2 min-w-[68px]">
          <div className="w-[68px] h-[68px] rounded-full bg-secondary flex items-center justify-center">
            <action.icon className="h-6 w-6 text-foreground" />
          </div>
          <span className="text-xs text-foreground text-center leading-tight whitespace-pre-line font-body">
            {action.label}
          </span>
        </button>
      ))}
    </div>
  </section>
);

export default PainelQuickActions;
