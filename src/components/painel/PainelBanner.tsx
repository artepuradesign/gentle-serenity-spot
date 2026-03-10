const PainelBanner = () => (
  <section className="px-5 pb-4">
    <p className="text-sm text-muted-foreground font-body mb-3">Meus cards</p>
    <div className="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
      <div className="min-w-[280px] h-[170px] rounded-2xl bg-secondary p-5 flex flex-col justify-between">
        <p className="text-sm text-foreground font-body">
          Traga seus dados e <strong className="font-heading">aumente suas chances de crédito.</strong>
        </p>
        <span className="text-xs text-primary font-heading font-bold">Saiba mais →</span>
      </div>
      <div className="min-w-[280px] h-[170px] rounded-2xl bg-secondary p-5 flex flex-col justify-between">
        <p className="text-sm text-foreground font-body">
          <strong className="font-heading">Indique amigos</strong> para o Nu e ganhe benefícios exclusivos.
        </p>
        <span className="text-xs text-primary font-heading font-bold">Indicar →</span>
      </div>
    </div>
  </section>
);

export default PainelBanner;
